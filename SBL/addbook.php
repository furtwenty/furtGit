<?php 

echo dysplayform();

function dysplayform(){

	echo '
			<br>
			Book Title (1000 char limt):
			<input type="text" id="addbname" name="booktitle"/>
			<label id="addbnerr" ></label>
			<br>
			<br>
			Book Author (250 char limit):
			<input type="text" id="addbauth" name="bookauthor"/>
			<label id="addbaerr" ></label>
			<br>
			<br>
			Book ID (250 char Limit):
			<input type="text" id="addbid" name="bookid"/>
			<label id="addbierr" ></label>
			<br>
			<input type="button" id="subaddbook" value="submit" />
			
		';
}

?>