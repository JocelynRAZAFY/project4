<?php
/**
 * Created by PhpStorm.
 * User: dave
 * Date: 25/06/19
 * Time: 13:14
 */

namespace App\Services;


class BookService
{
    /**
     * @var Tools
     */
    private $tools;

    /**
     * BookService constructor.
     * @param Tools $tools
     */
    public function __construct(Tools $tools)
    {
        $this->tools = $tools;
    }

    public function loopAllBook($prefix, $lang)
    {
        libxml_use_internal_errors(true);

        foreach ($this->tools->getArrayCodeFamille() as $livre) {
            $nbLivre = $livre['nb'];
            $livre = $livre['livre'];

            $this->loopBook($livre, $nbLivre, $prefix, $lang);
        }

        libxml_use_internal_errors(false);
    }

    /**
     * @param $livre
     * @param $nbLivre
     * @param $prefix
     * @param $lang
     */
    public function loopBook($livre, $nbLivre, $prefix, $lang)
    {

        libxml_use_internal_errors(true);

        $famille = $livre;

        for ($chapter = 1; $chapter <= $nbLivre; $chapter++) {

            $data = $this->getContentBook($chapter, $livre, $prefix);

            $filePathTemp = __DIR__ . '/../../public/bibles/exemple.html';

            $this->putContentBookInTemp($data,$filePathTemp);

            $file = new \SplFileObject($filePathTemp);
            $delimiter = $this->tools->guessFileDelimiter($filePathTemp);

            $this->createBookFile($file, $delimiter, $lang, $famille, $livre, $chapter, $prefix);

        }

        libxml_use_internal_errors(false);
    }

    /**
     * @param $chapter
     * @param $livre
     * @param $prefix
     * @return false|string
     */
    public function getContentBook($chapter, $livre, $prefix)
    {
        if ($chapter == 1) {
            $data = file_get_contents('https://emcitv.com/bible/' . $livre.'-'.$prefix . '.html');
        } else {
            $data = file_get_contents('https://emcitv.com/bible/' . $livre . '-' . $chapter .'-'. $prefix . '.html');
        }

        return $data;
    }

    /**
     * @param $data
     * @param $filePathTemp
     */
    public function putContentBookInTemp($data,$filePathTemp)
    {
        $doc = new \DOMDocument();
        $doc->loadHTML($data);
        $divs = $doc->getElementsByTagName('div');
        foreach ($divs as $div) {
            // Loop through the DIVs looking for one withan id of "content"
            // Then echo out its contents (pardon the pun)
            if ($div->getAttribute('class') === 'list-verses') {
                $value = str_replace("\r\n", "", $div->nodeValue);
                $value = str_replace("\t\t\t    \t\n", "", $value);
                $value = str_replace("\n\n\n\n", "", $value);
                $value = str_replace("\n\n", "", $value);
                $value = str_replace("\t\t\t", "", $value);
                $value = str_replace("\"\"\"", "", $value);

                file_put_contents($filePathTemp, trim($value));
            }
        }
    }

    /**
     * @param $file
     * @param $delimiter
     * @param $lang
     * @param $famille
     * @param $livre
     * @param $chapter
     * @param $prefix
     */
    public function createBookFile($file, $delimiter, $lang, $famille, $livre, $chapter, $prefix)
    {
        $dir = __DIR__ . '/../../public/bibles/' . $lang . '/' . $famille;
        $book = __DIR__ . '/../../public/bibles/' . $lang . '/' . $famille . '/' . $livre . '-' . $chapter .'-'. $prefix . '.txt';
        if(!is_dir($dir)){
            mkdir($dir,0777,true);
        }

        if(file_exists($book)){
            unlink($book);
        }

        $index = 1;
        $verser = '';
        while ($file->valid()) {
            $line = $file->fgets();

            $rowContent = explode($delimiter, $line);
            if ($rowContent[0] != "") {
                if ($index == 1) {
                    $verser = $rowContent[0];
                    $index++;
                } else {
                    $verser .= $rowContent[0];
                    $index = 1;
                    //$percent = round(($k * 100)/$nbLivre,2);
                    // $output->writeln($percent);

                    file_put_contents($book, $verser . PHP_EOL, FILE_APPEND | LOCK_EX);
                }
            }
        }
    }
}