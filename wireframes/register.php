<?php $body_class = 'login'; ?>
<?php include_once '_header.php'; ?>
<form action="register2.php">
	<input type="text" placeholder="first name" />
	<input type="text" placeholder="last name" /><br />
	<input type="text" placeholder="phone number" /><br />
	<input type="text" placeholder="email address" /><br />
	<input type="password" placeholder="password" /><br />
	<input type="password" placeholder="password confirmation" /><br />
	<p>To verify that you are part of the SCDS community, please provide the following information:<p>	
	<input type="text" placeholder="youngest enrolled student's grade level" /><br />
	<input type="text" placeholder="youngest enrolled student's homeroom teacher" /><br />
	<input type="submit" value="Request Account" />
</form>
<?php include_once '_footer.php'; ?>