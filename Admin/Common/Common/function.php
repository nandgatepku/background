<?php
/**
 * Created by PhpStorm.
 * User: PTcZn
 * Date: 2017/11/6
 * Time: 22:05
 */
function exportexcel($data,$title,$filename){
    header("Content-type:application/octet-stream");
    header("Accept-Ranges:bytes");
    header("Content-type:application/vnd.ms-excel");
    header("Content-Disposition:attachment;filename=".$filename.".xls");
    header("Pragma: no-cache");
    header("Expires: 0");
    //导出xls 开始
    if (!empty($title)){
        foreach ($title as $k => $v) {
            $title[$k]=iconv("UTF-8", "GB2312",$v);
        }
        $title= implode("\t", $title);
        echo "$title\n";
    }
    if (!empty($data)){
        foreach($data as $key=>$val){
            foreach ($val as $ck => $cv) {
                $data[$key][$ck]=iconv("UTF-8", "GB2312", $cv);
            }
            $data[$key]=implode("\t", $data[$key]);
        }
        echo implode("\n",$data);
    }
}

//class ExcelToArrary extends service
//{

function __construct()
    {

        /*导入phpExcel核心类    注意 ：你的路径跟我不一样就不能直接复制*/
        include_once('http://localhost/dxwork/ThinkPHP/Library/Vendor/PHPExcel.php');
    }

    /* 导出excel函数*/
function push($datau, $name = 'Excel')
    {
        include '/Classes/PHPExcel.php';
        error_reporting(E_ALL);
        date_default_timezone_set('Asia/Shanghai');
        $objPHPExcel = new PHPExcel();

        $objPHPExcel->getProperties()->setCreator("PTcZn");
        $objPHPExcel->getProperties()   ->setLastModifiedBy("PTcZn");
        $objPHPExcel->getProperties()  ->setKeywords("excel");
        $objPHPExcel->getProperties()  ->setCategory("result file");

        $num=1;
        $objPHPExcel->setActiveSheetIndex()->setCellValue('A' . $num, 'id');
        $objPHPExcel->setActiveSheetIndex() ->setCellValue('B' . $num, 'name');
        $objPHPExcel->setActiveSheetIndex() ->setCellValue('C' . $num, 'pwd');
        $objPHPExcel->setActiveSheetIndex() ->setCellValue('D' . $num, 'wechat');

        foreach ($datau as $v) {
            $num ++;
            $objPHPExcel->setActiveSheetIndex()->setCellValue('A' . $num, $v['id']);
            $objPHPExcel->setActiveSheetIndex() ->setCellValue('B' . $num, $v['name']);
            $objPHPExcel->setActiveSheetIndex() ->setCellValue('C' . $num, $v['pwd']);
            $objPHPExcel->setActiveSheetIndex() ->setCellValue('D' . $num, $v['wechat']);
        }

        $objPHPExcel->getActiveSheet()->setTitle('User');
        $objPHPExcel->setActiveSheetIndex(0);
        ob_end_clean();
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $name . '.xls"');
        header('Cache-Control: max-age=0');
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');
        exit;
    }
//}
function uxlsread($filename,$encode='utf-8')
{
    include '/Classes/PHPExcel.php';
    $objReader = PHPExcel_IOFactory::createReader('Excel5');
    $objReader->setReadDataOnly(true);
    $objPHPExcel = $objReader->load($filename);
    $objWorksheet = $objPHPExcel->getActiveSheet();
    $highestRow = $objWorksheet->getHighestRow();
    $highestColumn = $objWorksheet->getHighestColumn();
    $highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn);
    $excelData = array();
    for ($row = 1; $row <= $highestRow; $row++) {
        for ($col = 0; $col < $highestColumnIndex; $col++) {
        $excelData[$row][] =(string)$objWorksheet->getCellByColumnAndRow($col, $row)->getValue();
        }
    }
    return $excelData;
}



?>