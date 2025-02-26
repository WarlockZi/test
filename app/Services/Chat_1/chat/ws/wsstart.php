<?php
/*
* ws-file starter. 
* ���� ���� ����������� �� AJAX ������� �� �������, ���� ���� �������� ������������ {run:1} - ��� �������, {run:2} - ������ ����� �������
*
*/

define( 'ABSPATH', dirname(__FILE__) . '/../' );

require_once(ABSPATH."class/ws.php");

require(ABSPATH."cfg/ws.cfg.php");

if( file_exists($GLOBALS['ws']['pidfile']) ) {	//�� ����� ������ ������� �������� �� ������������ � ������� ������, pid-���� ����, ������ �� ��������. 

	$pid = ws::getstatusf($GLOBALS['ws']['pidfile']);

	if($pid>=0){
		echo "{run:1}"; //1 ��� �������
		exit;
	} elseif($pid==-2){	//���� ���� � �������� ���
		unlink($GLOBALS['ws']['pidfile']);
		ws::consolemsg("wsstart.php - previously abnormal process termination");
		ws::consolemsg("wsstart.php - pidfile ".$pidfile." ulinked");
		ws::consolemsg("wsstart.php - try to run again");
	} elseif($pid==-1){ //������ ��� �� ����� �� ��������
		//��� �������� �������������� � ����� ������ ��������� ������� �����
	}
} 


//���� �� ��� ������� - ���������
if (strtoupper(substr(PHP_OS,0,3)) === 'WIN') {  //�������� ��� ������
	pclose(popen($GLOBALS['ws']['wincommandtostart'], "r"));
} else	exec($GLOBALS['ws']['commandtostart']);
echo "{run:2}"; //2 ������ ����� �������

?>