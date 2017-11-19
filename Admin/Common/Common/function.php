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

function __construct()
    {

        /*导入phpExcel核心类    注意 ：你的路径跟我不一样就不能直接复制*/
        include_once('http://localhost/dxwork/ThinkPHP/Library/Vendor/PHPExcel.php');
    }

    /* 导出excel函数*/
function push($datau, $name = 'Excel')
{
        include 'Classes/PHPExcel.php';
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
    include 'Classes/PHPExcel.php';
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

function export_pdf($list,$ename){
//    include 'Classes/tcpdf/tcpdf.php';
//    date_default_timezone_set("PRC");
    ob_start();
    vendor('tcpdf.tcpdf_import','ThinkPHP/Library/Vendor','.php');
    $pdf = new \Tcpdf(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
    // 设置打印模式
    $pdf->SetCreator(PDF_CREATOR);
    $pdf->SetAuthor('ptczn');
    $pdf->SetTitle($ename);
    $pdf->SetSubject('TCPDF Tutorial');
    $pdf->SetKeywords('TCPDF, PDF, example, test, guide');
    // 是否显示页眉
    $pdf->setPrintHeader(false);
    // 设置页眉显示的内容
    $pdf->SetHeaderData('logo.png', 60, ' ', '', array(0,64,255), array(0,64,128));
    // 设置页眉字体
    $pdf->setHeaderFont(Array('dejavusans', '', '12'));
    // 页眉距离顶部的距离
    $pdf->SetHeaderMargin('5');
    // 是否显示页脚
    $pdf->setPrintFooter(true);
    // 设置页脚显示的内容
    $pdf->setFooterData(array(0,64,0), array(0,64,128));
    // 设置页脚的字体
    $pdf->setFooterFont(Array('dejavusans', '', '10'));
    // 设置页脚距离底部的距离
    $pdf->SetFooterMargin('10');
    // 设置默认等宽字体
    $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
    // 设置行高
    $pdf->setCellHeightRatio(1);
    // 设置左、上、右的间距
    $pdf->SetMargins('10', '10', '10');
    // 设置是否自动分页  距离底部多少距离时分页
    $pdf->SetAutoPageBreak(TRUE, '15');
    // 设置图像比例因子
    $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
    if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
        require_once(dirname(__FILE__).'/lang/eng.php');
        $pdf->setLanguageArray($l);
    }
    $pdf->setFontSubsetting(true);
    $pdf->AddPage();
    // 设置字体
    $pdf->SetFont('stsongstdlight', '', 14, '', true);
    $pdf->MultiCell($w, $h, $list, $border=0, $align='J', $fill=0, $ln=1, $x='', $y='', $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=0);
    $rows = count($list);
    $pdf->writeHTMLCell(0, 0, '', '', 'user & wechat', 0, 1, 0, true, 'C', true);
    for ($i=0;$i<$rows;$i++){
        $pdf->writeHTMLCell(0, 0, '', '', $list[$i]['id'], 1, 1, 0, true, '', true);
        $pdf->writeHTMLCell(0, 0, '', '', $list[$i]['name'], 0, 1, 0, true, '', true);
        $pdf->writeHTMLCell(0, 0, '', '', $list[$i]['wechat'], 0, 1, 0, true, '', true);
    }
//    $pdf->writeHTMLCell(0, 0, '', '', $list[3]['name'], 0, 1, 0, true, '', true);
    //$pdf->writeHTMLCell($list);
    //$pdf->writeHTMLCell();
    $pdf->Output($ename.'.pdf', 'I');
}
?>