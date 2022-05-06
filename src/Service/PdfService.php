<?php

namespace App\Service;

use Doctrine\DBAL\Query;
use Dompdf\Dompdf;
use Dompdf\Options;

class PdfService
{

    private $domPdf;

    public function __construct()
    {
        $this->domPdf = new Dompdf();

        $pdfOptions = new Options();

        $pdfOptions->set('defaultFont', 'Garamond');

        $this->domPdf->setOptions($pdfOptions);
    }

    public function showPdf($html)
    {
        $this->domPdf->loadHtml($html);
        $this->domPdf->render();
        $this->domPdf->stream($filename = 'detaile.pdf', $option = [
            'Attachement' => false
        ]);
    }

    public function generateBenaryPdf($html)
    {
        $this->domPdf->loadHtml($html);
        $this->domPdf->render();
        $this->domPdf->output();
    }
}
