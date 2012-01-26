<?
/*
    This file is part of vado!vado.

    vado!vado is free software: you can redistribute it and/or modify
    it under the terms of the GNU Affero General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    vado!vado is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU Affero General Public License for more details.

    You should have received a copy of the GNU Affero General Public License
    along with vado!vado.  If not, see <http://www.gnu.org/licenses/>.
*/

$data_folder = dirname(__FILE__).'/data/';


// form submit case
if(isset($_GET['meeting'])) {
	// TODO: control input data
	$dfile = $data_folder.date("Ymd",$_GET['meeting']);
	$data = Array('no'=>Array(),'yes'=>Array());
	if(file_exists($dfile)) {
		$data = json_decode(file_get_contents($dfile),true);
		
		if(array_search($_GET['user_id'],$data['yes']) !== false ||
				array_search($_GET['user_id'],$data['no']) !== false) {
			header("location: ./?res=already+voted");
			exit();
		}
	}
	$vado = $_GET['attending']=='true'? 'yes' : 'no';
	$data[$vado][] = $_GET['user_id'];
	file_put_contents($dfile, json_encode($data));
	header("location: ./?res=thankyou&details=".$_GET['meeting']);
	exit();
}

if(isset($_GET['details'])) {
	$dfile = $data_folder.date("Ymd",$_GET['details']);
	$data = json_decode(file_get_contents($dfile),true);
}

$next_meeting = "next tuesday 20:00";
$next_meeting_date = strtotime($next_meeting);


$random_md5 = md5(mt_rand().mt_rand());

?>
<!DOCTYPE html>
<html>
<head>
<title>vado!vado - planner dei meeting informali del lugbz</title>
<link type="text/css" rel="stylesheet" href="css/style.css">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
<script type="text/javascript">
	window.rand_id = '<?php echo $random_md5?>';
</script>
<script type="text/javascript" src="js/herewego.js"></script>
</head>
<body>
<h1>Prossimo&nbsp;incontro:<br><?php echo date('d/m/Y H:i',$next_meeting_date)?></h1>
<?php if(!isset($data)) { ?>
<form action="#">
<input type="hidden" value="<?php echo $next_meeting_date?>" name="meeting" />
<input type="hidden" value="<?php echo $random_md5?>" name="user_id" id="input_user_id"/>
<div id="choices">
<input type="radio" value="true" id="attending" name="attending" />
<label for="attending">Vado</label>
<input type="radio" value="false" id="notattending" name="attending" />
<label for="notattending">Non Vado</label>
</div>
<input type="submit" />
</form>
<?php } else {?>
<table>
	<tr><td>Vanno</td><td><?php echo count($data['yes']); ?></td></tr>
	<tr><td>Non Vanno</td><td><?php echo count($data['no']); ?></td></tr>
</table>
<?php }?>
<p class="notes">
vado!vado is a project by Daniele Gobbetti. It's free software released under the Affero GPLv3 license or any later version. Get the sources or fork me on <a href="https://github.com/danielegobbetti/vadononvado">github</a></p>
</body>
</html>
