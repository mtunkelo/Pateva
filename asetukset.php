<?php include("navi.php"); ?>
<div id="about" class="container-fluid">
	<div class="row">
		<div class="col-sm-2"></div>
		<div class="col-sm-6">
      	<?php
							if (isset ( $_POST ['username'] ) && ! empty ( $_POST ['username'] )) {
								$username = $_POST ['username'];
								echo $username;
								$cookie_value = $_POST ['username'];
								setcookie ( 'namecookie', $cookie_value, time () + 60 * 60 * 24 * 7, '/' );
							}
							
							if (isset ( $_COOKIE ["namecookie"] )) {
								$username = $_COOKIE ["namecookie"];
							} else {
								$username = "";
							}
							
							if (isset ( $_POST ["submit"] )) {
								header ( "location: index.php" );
								exit ();
							}
							?>
      <h2>Asetukset</h2>
				<form method="post"
					action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">

					<label>Nimesi:</label> <input type="text" name="username" size="30"
						value="<?php echo $username;?>"> <input type="submit"
						name="submit" value="Tallenna nimi">
				</form>
			</div>
		</div>
	</div>

<?php include("footer.php"); ?>

