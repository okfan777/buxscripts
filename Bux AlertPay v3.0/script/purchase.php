<? include('header.php'); ?>




<?
if (isset($_POST["customer"]))
{

$refset=$_POST["refset"];



require('config.php');
$queryx = mysql_query("SELECT sets FROM tb_buyref WHERE id='1' and refnum='$refset'") or die(mysql_error());
$rowx = mysql_fetch_array($queryx);
mysql_close($con);
if ($rowx["sets"]=="0")
{
echo "<font color=\"red\">Sorry there is no sets available right now.</font><br><br>";
}else{


// Si todo parece correcto procedemos con la inserccion

$setz=$rowx["sets"] - 1;
require('config.php');
$queryb = "UPDATE tb_buyref SET sets='$setz' WHERE id='1' and refnum='$refset'";
mysql_query($queryb) or die(mysql_error());
mysql_close($con);

$customer=limpiar($_POST["customer"]);
$pemail=limpiar($_POST["pemail"]);
$refset=limpiar($_POST["refset"]);
$precio=$_POST["price"];
$laip = getRealIP();
require('config.php');
//Todo parece correcto procedemos con la inserccion
$queryzz = "INSERT INTO tb_buyref (customer, amount, refset, pemail, ip) VALUES('$customer','1','$refset', '$pemail','$laip')";
mysql_query($queryzz) or die(mysql_error());
mysql_close($con);

?>
<br>
<p>Your order has been submitted! However, before we will approve your purchase, you must pay <?
	require('config.php');
$sql = "SELECT * FROM tb_refset WHERE howmany='$refset'";
$result = mysql_query($sql);        
$row = mysql_fetch_array($result);
mysql_close($con);
$precio=$row["price"];
$description=$row["howmany"];
?>

$ <?= $precio ?> via AlertPay.<br></p>


<p><div align="center">


<!-- ALERTPAY GATEWAY -->

<form method="post" action="https://www.alertpay.com/PayProcess.aspx" >  
<input type="hidden" name="ap_purchasetype" value="service"/>  
<input type="hidden" name="ap_merchant" value="<? include('alertpay.php'); ?>"/>  
<input type="hidden" name="ap_itemname" value="<? include('sitename.php');?> - Purchase <?= $description ?> referals"/>  
<input type="hidden" name="ap_currency" value="USD"/>  
<input type="hidden" name="ap_returnurl" value="<?= $url ?>"/>  
<input type="hidden" name="ap_itemcode" value="01"/>  
<input type="hidden" name="ap_quantity" value="1"/>  
<input type="hidden" name="ap_description" value="Purchase <?= $description ?> referals"/>  
<input type="hidden" name="ap_amount" value="<?= $precio ?>"/>  
<input type="hidden" name="ap_cancelurl" value="<?= $url ?>"/>  
<input type="image" name="ap_image" src="https://www.alertpay.com/Images/BuyNow/big_pay_01.gif"/> 
</form>











</div>
</p>
<br>
<?

}

}else{
?>

<br><br><p>Why not let us do the referring for you? We know how difficult and time consuming referring others can be, especially when you simply don't have the time. In fact, we've already got newly registered members who joined without a referrer who we can automatically place beneath you and let you reap the rewards!
</p>
<p>You can purchase un-referred <? include('sitename.php'); ?> members for low prices. And this prices are extremely low to pay when you sit back and imagine your profits.
</p>
<p align="center"><img src="method.gif"></p>
<?

require('config.php');
$sqld = "SELECT * FROM tb_buyref WHERE customer='admin'";
$resultd = mysql_query($sqld);        
$rowd = mysql_fetch_array($resultd);
mysql_close($con);
?>

<br>
<div align="center"><div id="form">
<fieldset>
<legend>&nbsp;Availability&nbsp;</legend>

<?
require('config.php');
$tablaa = mysql_query("SELECT * FROM tb_buyref where id='1' ORDER BY id DESC"); // selecciono todos los registros de la tabla ads categories, ordenado por id
mysql_close($con);
while ($registroa = mysql_fetch_array($tablaa)) { // comienza un bucle que leera todos los registros y ejecutara las ordenes que siguen


echo "<p>&nbsp;&nbsp;Sets Available(".$registroa["refnum"] ." Referrals ): <b>".$registroa["sets"] ."</b></p>


";



}
?>
</fieldset>
</div></div>

<br>

<p class="warning">
<b>SERIOUS BUYERS ONLY! DO NOT COMPLETE THE FORM IF YOU HAVE NO INTENTIONS OF PURCHASING BECAUSE IT CHANGES THE QTY'S!<br /> WE will consider any non-intentive order submissions as abuse and won't hesitate to delete your account. <br />DO NOT click the "Pay Now" button below if you do not have intentions to purchase!</b>
</p>



<?

$user=uc($_COOKIE["usNick"]);
require('config.php');
$sql = "SELECT * FROM tb_users WHERE username='$user'";
$result = mysql_query($sql);        
$row = mysql_fetch_array($result);
mysql_close($con);
?>


<div align="center"><div id="form">
<fieldset>
<legend>&nbsp;Purchase&nbsp;</legend>

<form method="post" action="purchase.php">

<p>&nbsp;&nbsp;Customer: <b><?= $row["username"] ?></b><input type="hidden" value="<?= $row["username"] ?>" name="customer"></p>

<p>&nbsp;&nbsp;AlertPay email: <b><?= $row["pemail"] ?></b><input type="hidden" value="<?= $row["pemail"] ?>" name="pemail"></p>
<p>&nbsp;&nbsp;Purchase <b> 1 set</b> of


<select name="refset" class="combo">


<?
require('config.php');
$tablaa = mysql_query("SELECT * FROM tb_refset ORDER BY id ASC"); // selecciono todos los registros de la tabla ads categories, ordenado por id

while ($registroa = mysql_fetch_array($tablaa)) { // comienza un bucle que leera todos los registros y ejecutara las ordenes que siguen
mysql_close($con);

echo "

<option value=\"".$registroa["howmany"] ."\">". $registroa["howmany"] ." Referrals  - $". $registroa["price"] ." </option>

";



}
$refnum=$registroa["howmany"];
?>



</select></p>


<p><input type="submit" value="Pay Now" class="submit" tabindex="4" /></p>
</form>
</fieldset>
</div></div>
<?
}
?>



<? include('footer.php'); ?>