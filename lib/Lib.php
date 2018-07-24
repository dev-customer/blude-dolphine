<?php
/*
@Author : Anh.Nguyen
@DateCreate : 18/8/2010
@Output : Function execute
@Name : Class Lib
*/
final class Lib{
	 //function create pdf from once file html
	 public function CreatePdfAllList($outputHtml,$title,$permission='F',$folder,$front=false){
		require_once('tcpdf/config/lang/eng.php');
		require('tcpdf/tcpdf.php');
		// create new PDF document
		$pdf = new TCPDF(PDF_PAGE_ORIENTATION,PDF_UNIT,PDF_PAGE_FORMAT, true,'UTF-8',false); 
		
		// set document information
		$pdf->SetCreator(PDF_CREATOR);
		$pdf->SetAuthor('TBL Projects');
		$pdf->SetTitle('TBL Projects-PDF');
		$pdf->SetSubject($title);
		$pdf->SetKeywords($title);
		// remove default header/footer
		$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);

		// set header and footer fonts
		$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
		$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
		
		$pdf->setPrintHeader(true);
		$pdf->setPrintFooter(true);
		//set margins
		$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
		$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
		$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
		//set auto page breaks
		$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
		//set some language-dependent strings
		$pdf->setLanguageArray($l); 
		$pdf->SetBooklet(true, 20, 45);
		// ---------------------------------------------------------
		// set font
		$pdf->SetFont('dejavusans','', 9);// add a page
		$pdf->AddPage();
		$pdf->writeHTML(str_replace('<br>','<br />',$outputHtml),true, 0, true, true);		
		//Close and output PDF document
		if($permission=='F'){
			if($front==true){
				$pdf->Output('upload/'.$folder.'/'.$title.'.pdf','F');
			}
				else
			{
				$pdf->Output('../upload/'.$folder.'/'.$title.'.pdf','F');
			}
			return $title.'.pdf';
		}
			else
		{
			$pdf->Output($title.'.pdf',$permission);
			return $title.'.pdf';
		}
	}
	//function format money
	public function formatMoney($number, $cents = 0) { // 
	  if (is_numeric($number)) { // a number
		if (!$number) { // zero
		  $money = ($cents == 2 ? '0.00' : '0'); // output zero
		} else { // value
		  if (floor($number) == $number) { // whole number
			$money = number_format($number, ($cents == 2 ? 2 : 0)); // format
		  } else { // cents
			$money = number_format(round($number, 2), ($cents == 0 ? 0 : 2)); // format
		  } // integer or decimal
		} // value
		return str_replace(",",".",$money);
	  } // numeric
	} // formatMoney
	//get curency
	public function getCurcenry($id){
		global $arrCurcenry;
		if($id>0) return $arrCurcenry[$id];
		else return "";
	}
	//send email all
	public function sendEmail($from,$fromName,$to,$toName,$subject,$body,$attachment=""){
		//inlucde lib for mail
		require_once("mail/class.phpmailer.php");
		require_once("mail/class.smtp.php");
		$mail = new PHPMailer();
		if(MAIL_STMP==true){
			$mail->IsSMTP();
			$mail->Host = "smtp.gmail.com";
			$mail->Port = 465;
			$mail->SMTPAuth = true;
			$mail->SMTPSecure = 'ssl';
			$mail->Username = USERNAME_GMAIL;
			$mail->Password = PASS_GMAIL;
		}
		$mail->From = $from;
		$mail->FromName = $fromName; // Name to indicate where the email came from when the recepient received
		$mail->AddAddress($to,$toName);
		$mail->AddReplyTo($from,$fromName);
		$mail->WordWrap = 50; // set word wrap
		$mail->IsHTML(true);
		$mail->Subject = $subject;
		$mail->Body = $body; //HTML Body
		$mail->AltBody = "Send by tbl.vn (c) 2010"; //Text Body
		if(!empty($attachment)){
			$mail->AddAttachment($attachment);
		}
		if(!$mail->Send()){
			return false;
		}
			else
		{
			return true;
		}
	}
	//download file name
	public function download_file($filename,$name){           
        $file_extension = strtolower(substr(strrchr($filename,"."),1));
        switch( $file_extension ){
          case "pdf": $ctype="application/pdf"; break;
          case "exe": $ctype="application/octet-stream"; break;
          case "zip": $ctype="application/zip"; break;
          case "doc": $ctype="application/msword"; break;
          case "xls": $ctype="application/vnd.ms-excel"; break;
          case "ppt": $ctype="application/vnd.ms-powerpoint"; break;
          case "gif": $ctype="image/gif"; break;
          case "png": $ctype="image/png"; break;
          case "jpeg":
          case "jpg": $ctype="image/jpg"; break;
          default: $ctype="application/force-download";
        }
        header("Pragma: public");
        header("Expires: 0");
        header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
        header("Cache-Control: private",false);
        header("Content-Type: $ctype");        
        header("Content-Disposition: attachment; filename=\"".basename($name.'.'.$file_extension)."\";" );
        header("Content-Transfer-Encoding: binary");
        header("Content-Length: ".filesize($filename));
        ob_end_clean();
        readfile("$filename");
        exit();             
    }
	
	//get date
	public function _getDate($date,$type='vn'){
		$arrDate = explode(' ',$date);
		$arrDateOut = explode('-',$arrDate[0]);		
		$theDay = "";
		if($type=='vn'){
			if($arrDateOut[2]=='00'){
				$theDay = $arrDateOut[1].'/'.$arrDateOut[0];
			}
				else
			{
				$theDay = $arrDateOut[2].'/'.$arrDateOut[1].'/'.$arrDateOut[0];
			}			
		}
			else
		{
			$theDay = $arrDateOut[1].'/'.$arrDateOut[2].'/'.$arrDateOut[0];
		}
		return $theDay;
	}
	
}
//================end================//
?>