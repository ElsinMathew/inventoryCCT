<?php
require_once('includes/autoload.php');

class Invoice extends FPDF_rotation
{
    private $font = 'helvetica';
    private $columnOpacity = 0.06;
    private $columnSpacing = 0.3;
    private $referenceFormat = array('.', ',');
    private $margins = array('l' => 20, 't' => 20, 'r' => 20);

    public $title;
    private $color;
    private $date;
    private $due;
    private $logo;
    private $from;
    private $to;
    private $ship;
    private $items;
    private $totals;
    private $badge;
    private $addText;
    private $footernote;
    private $dimensions;

    private $columns = 5;
    private $firstColumnWidth = 70;
    private $currency = '€';
    private $maxImageDimensions = array(230, 130);
    private $language;
    private $document = array('w' => 210, 'h' => 297);

    public function __construct($size = 'A4', $currency = '€', $language = 'en')
    {
        $this->items = array();
        $this->totals = array();
        $this->addText = array();
        $this->setLanguage($language);
        $this->setDocumentSize($size);
        $this->setColor("#222222");

        parent::__construct('P', 'mm', array($this->document['w'], $this->document['h']));
        $this->AliasNbPages();
        $this->SetMargins($this->margins['l'], $this->margins['t'], $this->margins['r']);
    }

    public function SetTitle($title, $isUTF8 = false)
    {
        $this->title = $title;
    }

    public function setColor($rgbcolor)
    {
        $this->color = $this->hex2rgb($rgbcolor);
    }

    public function setDate($date)
    {
        $this->date = $date;
    }

    public function setDue($date)
    {
        $this->due = $date;
    }

    public function setLogo($logo = 0, $maxWidth = 0, $maxHeight = 0)
    {
        if ($maxWidth && $maxHeight) {
            $this->maxImageDimensions = array($maxWidth, $maxHeight);
        }
        $this->logo = $logo;
        $this->dimensions = $this->resizeToFit($logo);
    }

    public function setFrom($data)
    {
        $this->from = array_filter($data);
    }

    public function setTo($data)
    {
        $this->to = $data;
    }

    public function shipTo($data)
    {
        $this->ship = $data;
    }

    public function setReference($reference)
    {
        $this->reference = $reference;
    }

    public function setNumberFormat($decimals, $thousands_sep)
    {
        $this->referenceFormat = array($decimals, $thousands_sep);
    }

    public function flipflop()
    {
        $this->flipflop = true;
    }

    public function addItem($item, $description, $quantity, $vat, $price, $discount = 0, $total)
    {
        $p['item'] = $item;
        $p['description'] = $this->br2nl($description);
        $p['vat'] = is_numeric($vat) ? $this->currency . ' ' . number_format($vat, 2, $this->referenceFormat[0], $this->referenceFormat[1]) : $vat;
        $p['quantity'] = $quantity;
        $p['price'] = $price;
        $p['total'] = $total;

        if ($discount !== false) {
            $this->firstColumnWidth = 58;
            $p['discount'] = $discount;
            $p['discount'] = is_numeric($discount) ? $this->currency . ' ' . number_format($discount, 2, $this->referenceFormat[0], $this->referenceFormat[1]) : $discount;
            $this->discountField = true;
            $this->columns = 6;
        }

        $this->items[] = $p;
    }

    public function addTotal($name, $value, $colored = 0)
    {
        $t['name'] = $name;
        $t['value'] = is_numeric($value) ? $this->currency . ' ' . number_format($value, 2, $this->referenceFormat[0], $this->referenceFormat[1]) : $value;
        $t['colored'] = $colored;
        $this->totals[] = $t;
    }

    public function addTitle($title)
    {
        $this->addText[] = array('title', $title);
    }

    public function addParagraph($paragraph)
    {
        $paragraph = $this->br2nl($paragraph);
        $this->addText[] = array('paragraph', $paragraph);
    }

    public function addBadge($badge)
    {
        $this->badge = $badge;
    }

    public function setFooternote($note)
    {
        $this->footernote = $note;
    }

    public function render($name = '', $destination = '')
    {
        $this->AddPage();
        $this->Body();
        $this->AliasNbPages();
        $this->Output($name, $destination);
    }

    public function Header()
    {
        // Your Header code here
    }

    public function Body()
    {
        // Your Body code here
    }

    public function Footer()
    {
        // Your Footer code here
    }

    private function setLanguage($language)
    {
        $this->language = $language;
        $languageFile = 'languages/' . $language . '.inc';
        if (file_exists($languageFile)) {
            include($languageFile);
            $this->l = $l;
        } else {
            $this->l = array(); // Empty language array if the file doesn't exist
        }
    }

    private function setDocumentSize($dsize)
    {
        switch ($dsize) {
            case 'A4':
                $document['w'] = 210;
                $document['h'] = 297;
                break;
            case 'letter':
                $document['w'] = 215.9;
                $document['h'] = 279.4;
                break;
            case 'legal':
                $document['w'] = 215.9;
                $document['h'] = 355.6;
                break;
            default:
                $document['w'] = 210;
                $document['h'] = 297;
                break;
        }
        $this->document = $document;
    }

    private function resizeToFit($image)
    {
        list($width, $height) = getimagesize($image);
        $newWidth = $this->maxImageDimensions[0] / $width;
        $newHeight = $this->maxImageDimensions[1] / $height;
        $scale = min($newWidth, $newHeight);
        return array(
            round($this->pixelsToMM($scale * $width)),
            round($this->pixelsToMM($scale * $height))
        );
    }

    private function pixelsToMM($val)
    {
        return $val * 25.4 / 72;
    }

    private function hex2rgb($hex)
    {
        $hex = ltrim($hex, '#');
        if (strlen($hex) === 3) {
            $hex = str_repeat(substr($hex, 0, 1), 2) .
                str_repeat(substr($hex, 1, 1), 2) .
                str_repeat(substr($hex, 2, 1), 2);
        }
        return array(
            hexdec(substr($hex, 0, 2)),
            hexdec(substr($hex, 2, 2)),
            hexdec(substr($hex, 4, 2))
        );
    }

    private function br2nl($text)
    {
        return preg_replace('/<br\\s*?\/??>/i', "\n", $text);
    }

}
