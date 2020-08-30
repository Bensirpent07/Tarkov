<div id="selectionContainer">
	<div class="container">
		<div id="initialSelectionContainer" class="row">
			<div class="col-md-4">
				<a class="selectionButton" id="ammoButton">Ammo</a>
			</div>
			<div class="col-md-4">
				<a class="selectionButton" id="armorButton" href="#">Armor (Future Development)</a>
			</div>
            <div class="col-md-4">
                <a class="selectionButton" id="mapsButton" href="#">Maps (Future Development)</a>
            </div>
		</div>
		<div id="ammoSelection" class="row" style="display: none">
			<?php
				foreach($calibers as $caliber){
					$html = "
					<div class='col-md-2 caliberButtons'>
						<a class='selectionButton' href='ammo/$caliber''>$caliber</a>
					</div>
					";
					echo $html;
				}
			?>
		</div>
	</div>
</div>