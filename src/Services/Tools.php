<?php
/**
 * Created by PhpStorm.
 * User: dave
 * Date: 25/06/19
 * Time: 12:14
 */

namespace App\Services;


use Symfony\Component\HttpKernel\KernelInterface;

class Tools
{
    /**
     * @var array
     */

    private $livres = [
        ['id' => 1, 'livre'=> 'genese', 'nb' => 50],
        ['id' => 2, 'livre'=> 'exode', 'nb' => 40],
        ['id' => 3, 'livre'=> 'levitique', 'nb' => 27],
        ['id' => 4, 'livre'=> 'nombres', 'nb' => 36],
        ['id' => 5, 'livre'=> 'deuteronome', 'nb' => 34],
        ['id' => 6, 'livre'=> 'josue', 'nb' => 24],
        ['id' => 7, 'livre'=> 'juges', 'nb' => 21],
        ['id' => 8, 'livre'=> 'ruth', 'nb' => 4],
        ['id' => 9, 'livre'=> '1-samuel', 'nb' => 31],
        ['id' => 10, 'livre'=> '2-samuel', 'nb' => 24],
        ['id' => 11, 'livre'=> '1-rois', 'nb' => 22],
        ['id' => 12, 'livre'=> '2-rois', 'nb' => 25],
        ['id' => 13, 'livre'=> '1-chroniques', 'nb' => 29],
        ['id' => 14, 'livre'=> '2-chroniques', 'nb' => 36],
        ['id' => 15, 'livre'=> 'esdras', 'nb' => 10],
        ['id' => 16, 'livre'=> 'nehemie', 'nb' => 13],
        ['id' => 17, 'livre'=> 'esther', 'nb' => 10],
        ['id' => 18, 'livre'=> 'job', 'nb' => 42],
        ['id' => 19, 'livre'=> 'psaumes', 'nb' => 150],
        ['id' => 20, 'livre'=> 'proverbes', 'nb' => 31],
        ['id' => 21, 'livre'=> 'ecclesiaste', 'nb' => 12],
        ['id' => 22, 'livre'=> 'cantique-des-cantiques', 'nb' => 8],
        ['id' => 23, 'livre'=> 'esaie', 'nb' => 66],
        ['id' => 24, 'livre'=> 'jeremie', 'nb' => 52],
        ['id' => 25, 'livre'=> 'lamentations', 'nb' => 5],
        ['id' => 26, 'livre'=> 'ezechiel', 'nb' => 48],
        ['id' => 27, 'livre'=> 'daniel', 'nb' => 12],
        ['id' => 28, 'livre'=> 'osee', 'nb' => 14],
        ['id' => 29, 'livre'=> 'joel', 'nb' => 4],
        ['id' => 30, 'livre'=> 'amos', 'nb' => 9],
        ['id' => 31, 'livre'=> 'abdias', 'nb' => 1],
        ['id' => 32, 'livre'=> 'jonas', 'nb' => 4],
        ['id' => 33, 'livre'=> 'michee', 'nb' => 7],
        ['id' => 34, 'livre'=> 'nahum', 'nb' => 3],
        ['id' => 35, 'livre'=> 'habakuk', 'nb' => 3],
        ['id' => 36, 'livre'=> 'sophonie', 'nb' => 3],
        ['id' => 37, 'livre'=> 'agee', 'nb' => 2],
        ['id' => 38, 'livre'=> 'zacharie', 'nb' => 14],
        ['id' => 39, 'livre'=> 'malachie', 'nb' => 3],
        ['id' => 40, 'livre'=> 'matthieu', 'nb' => 28],
        ['id' => 41, 'livre'=> 'marc', 'nb' => 16],
        ['id' => 42, 'livre'=> 'luc', 'nb' => 24],
        ['id' => 43, 'livre'=> 'jean', 'nb' => 21],
        ['id' => 44, 'livre'=> 'actes', 'nb' => 28],
        ['id' => 45, 'livre'=> 'romains', 'nb' => 16],
        ['id' => 46, 'livre'=> '1-corinthiens', 'nb' => 16],
        ['id' => 47, 'livre'=> '2-corinthiens', 'nb' => 13],
        ['id' => 48, 'livre'=> 'galates', 'nb' => 6],
        ['id' => 49, 'livre'=> 'ephesiens', 'nb' => 6],
        ['id' => 50, 'livre'=> 'philippiens', 'nb' => 4],
        ['id' => 51, 'livre'=> 'colossiens', 'nb' => 4],
        ['id' => 52, 'livre'=> '1-thessaloniciens', 'nb' => 5],
        ['id' => 53, 'livre'=> '2-thessaloniciens', 'nb' => 3],
        ['id' => 54, 'livre'=> '1-timothee', 'nb' => 6],
        ['id' => 55, 'livre'=> '2-timothee', 'nb' => 4],
        ['id' => 56, 'livre'=> 'tite', 'nb' => 3],
        ['id' => 57, 'livre'=> 'philemon', 'nb' => 1],
        ['id' => 58, 'livre'=> 'hebreux', 'nb' => 13],
        ['id' => 59, 'livre'=> 'jacques', 'nb' => 5],
        ['id' => 60, 'livre'=> '1-pierre', 'nb' => 5],
        ['id' => 61, 'livre'=> '2-pierre', 'nb' => 3],
        ['id' => 62, 'livre'=> '1-jean', 'nb' => 5],
        ['id' => 63, 'livre'=> '2-jean', 'nb' => 1],
        ['id' => 64, 'livre'=> '3-jean', 'nb' => 1],
        ['id' => 65, 'livre'=> 'jude', 'nb' => 1],
        ['id' => 66, 'livre'=> 'apocalypse', 'nb' => 22],
    ];

    public static $delimiters = [
        "\t",
        "\n",
        ";",
        ":",
        "|"
    ];

    private $kernel;

    public function __construct(KernelInterface $kernel)
    {
        $this->kernel = $kernel;
    }

    public function getProjectDir()
    {
        return $this->kernel->getProjectDir();
    }

    public function searchLivre($value)
    {
        $item = null;
        foreach ($this->livres as $livre){
            if($livre['livre'] == $value){
                $item = $livre;
                break;
            }
        }

        return $item;
    }

    /**
     * @return array
     */
    public function getArrayCodeFamille()
    {
        return $this->livres;
    }

    /**
     * @param $file
     * @param int $checkLines
     * @return mixed
     */
    public function guessFileDelimiter($file, $checkLines=2){
        $file = new \SplFileObject($file);

        $delimiterUsage = [];
        $i = 0;

        while($file->valid() && $i <= $checkLines){
            $line = $file->fgets();

            foreach (self::$delimiters as $delimiter){
                if ($delimiter == '|'){
                    $regExp = "/\\".$delimiter."/";
                }
                else{

                    $regExp = "/".$delimiter."/";
                }

                $pregResult = [];
                preg_match_all($regExp, $line, $pregResult);
                $fieldsAmount = count($pregResult[0]);

                if(isset($delimiterUsage[$delimiter])){
                    $delimiterUsage[$delimiter] += $fieldsAmount;
                } else {
                    $delimiterUsage[$delimiter] = $fieldsAmount;
                }
            }

            $i++;
        }

        $mostUsedDelimiter = array_keys($delimiterUsage, max($delimiterUsage))[0];

        return $mostUsedDelimiter;
    }

    /**
     * @param $dir
     * @return array
     */
    public function getListFilenameDir($dir)
    {
        $files = scandir($dir);
        $filenames = [];
        foreach ($files as $file){
            if(pathinfo($file, PATHINFO_EXTENSION) == 'php') {
                $filenames[] = basename($file, ".php");
            }
        }

        return $filenames;
    }

    public function copyBaseFileToNewProject($fileTpl, $dirController, $newFileTplController, $entityName, $typeSrc,$extension)
    {

        if (!copy($fileTpl, $newFileTplController)) return false;

       // rename ("/folder/file.ext", "newfile.ext");
        $fileNew = $dirController.'/'.$entityName.''.$typeSrc.'.'.$extension;

        if (!rename ($newFileTplController,$fileNew )) return false;

        return $fileNew;
    }

    public function updateContentsFile($fileRename, $entityName)
    {

        $strEntityName = strtolower($entityName);
        $str = file_get_contents($fileRename);

        $str = str_replace('Entity',$entityName,$str);
        $str = str_replace('entity',$strEntityName,$str);

        file_put_contents($fileRename,$str);
    }
}