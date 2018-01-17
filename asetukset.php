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
					<div class="form-group"> 
						<label for="username" class="control-label">Nimesi</label>
						<input type="text" class="form-control" name="username" value="<?php echo $username;?>">
					</div>
						<button type="submit" name="submit" class="btn">Tallenna nimi</button>
				</form>
			</div>
		</div>
	</div>

<?php include("footer.php"); ?>
