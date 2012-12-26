<?php
	include_once('../backend/headsail_dal.php');
	include_once('../backend/mainsail_dal.php');
	include_once('../backend/maneuver_dal.php');
	include_once('../backend/mark_dal.php');
?>
<!DOCTYPE HTML>
<html>
	<head>
		<title>SeaPal</title>
		<?php include("htmlhead.php"); ?>
		<link type="text/css" rel="stylesheet" href="lib/datepicker/css/datepicker.css" />
		<script type="text/javascript" src="lib/datepicker/js/bootstrap-datepicker.js"></script>
		<script type="text/javascript" src="js/log_entry.js"></script>
		<script type="text/javascript" src="https://maps.google.com/maps/api/js?key=AIzaSyAL6gKFmwH7gDXmmAW-5VqkW_HbJG7_QLA&sensor=false"></script>
		<script type="text/javascript" src="lib/label.js"></script>
		<script type="text/javascript" src="lib/seamap/seamap-1.0.0.js"></script>
	</head>
	<body class="withsubnavi">

		<div class="header-wrapper">
			<?php include("header.php"); ?>
		</div>

		<div class="content-wrapper">
			<form id="form" method="post" action="../backend/log_entry_service.php">
				<input type="hidden" name="method" value="save" />
				<input type="hidden" id="trip_id" name="trip_id" value="<?= (array_key_exists('trip', $_GET) ? $_GET['trip'] : -1) ?>" />
				<div class="container">
					
					<div class="row">
						<div class="span8">
							<div class="left">
							<h1>Wegpunkt</h1>
							</div>
						</div>
						<div class="span4">
							<div class="right buttons_top">
								<input type="submit" id="submitBtn" class="btn btn-success" value="Speichern"/>
							</div>
						</div>
					</div>
					<div class="input-wrapper">
						<div class="row">
							<div class="span6">
								<label for="entry_name">Name</label>
								<input type="text" name="entry_name" style="width:100%;" tabindex="1" required />
							</div>
						</div>
						<div class="row">
							<div class="span6">
								<label for="north_degree">Position</label>
								<input type="number" class="compact" name="north_degree" size="3" tabindex="2" min="-89" max="89" required/>°
								<input type="number" class="compact" name="north_minutes" size="2" tabindex="3" min="0" max="59" required/>'
								<input type="number" class="compact" name="north_seconds" size="2" tabindex="4" min="0" max="59" required/>''N
								<input type="number" class="compact shift" name="east_degree" size="3" tabindex="5" min="-179" max="179" required/>°
								<input type="number" class="compact" name="east_minutes" size="2" tabindex="6" min="0" max="59" required/>'
								<input type="number" class="compact" name="east_seconds" size="2" tabindex="7" min="0" max="59" required/>''E
							</div>
							<div class="span2">
								<label for="cog">COG</label>
								<input type="number" name="cog" tabindex="10" min="0" step="0.1"/>
							</div>
							<div class="span2">
								<label for="sog">SOG</label>
								<input type="number" name="sog" tabindex="18" min="0" max="360" />
							</div>
							<div class="span2">
								<div class="datepicker-small input-append date" data-date="2013-01-17" data-date-format="yyyy-mm-dd">
									<label for="start_time">um</label>
									<input class="span2" size="16" type="text" name="datetime" tabindex="18" value="2013-01-17"/>
									<span class="add-on">
										<i class="icon-th"></i>
									</span>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="span3">
								<label for="btm">BTM</label>
								<input type="number" name="btm" tabindex="3" min="0" max="360" />
							</div>
							<div class="span3">
								<label for="dtm">DTM</label>
								<input type="number" name="dtm" tabindex="11" min="0" step="0.1" />
							</div>
							<div class="span4 offset2">
								<label for="trip_to">Fahrt nach</label>
								<select name="trip_to" size="1" style="width:100%;">
									<?php
										$marks = MarkDAL::loadAll();
										foreach ($marks as &$value) {
											echo '<option value="'.$value->getId().'">'.$value->getName().'</option>';
										}
									?>
								</select>
							</div>
						</div>
						<div class="row">
							<div class="span4">
								<label for="maneuver_id">Manöver</label>
								<select name="maneuver_id" size="1" style="width:100%;">
									<?php
										$maneuver = ManeuverDAL::loadAll();
										foreach ($maneuver as &$value) {
											echo '<option value="'.$value->getId().'">'.$value->getName().'</option>';
										}
									?>
								</select>
							</div>
							<div class="span4">
								<label for="headsail_id">Vorsegel</label>
								<select name="headsail_id" size="1" style="width:100%;">
									<?php
										$headsail = HeadsailDAL::loadAll();
										foreach ($headsail as &$value) {
											echo '<option value="'.$value->getId().'">'.$value->getName().'</option>';
										}
									?>
								</select>
							</div>
							<div class="span4">
								<label for="mainsail_id">Großsegel</label>
								<select name="mainsail_id" size="1" style="width:100%;">
									<?php
										$mainsail = MainsailDAL::loadAll();
										foreach ($mainsail as &$value) {
											echo '<option value="'.$value->getId().'">'.$value->getName().'</option>';
										}
									?>
								</select>
							</div>
						</div>	
					</div>
					<div class="gadgets-wrapper">
						<div class="row">
							<div class="span3">
								<div class="round">
									<div class="notes">
										<h4>Notes</h4>
										<div class="gadget">
											<textarea id="notes" name="note" cols="20" rows="20"></textarea>
										</div>
									</div>
								</div>
							</div>
							<div class="span6">
								<div class="round">
									<div id="mini_map"></div>
								</div>
							</div>
							<div class="span3">
								<div class="round">
									<div class="photos">
										<h4>Photos</h4>
										<div class="gadget">
											<img width="230" height="230" src="images/photo2.jpg"/>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>

			</div>
		</form>
		<div class="footer-wrapper">
			<?php include("footer.php"); ?>
		</div>
		<div id="addSuccessModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="addSuccessModalLabel" aria-hidden="true">
		  <div class="modal-header">
		    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
		    <h3 id="addSuccessModalLabel">Erfolgreich!</h3>
		  </div>
		  <div class="modal-body">
		    <p>Die Daten wurden erfolgreich übermittelt!</p>
		  </div>
		  <div class="modal-footer">
		    <button class="btn btn-primary" data-dismiss="modal" aria-hidden="true">OK</button>
		  </div>
		</div>
	</body>
</html>