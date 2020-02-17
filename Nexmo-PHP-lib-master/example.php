<?php
	include ( "./src/NexmoMessage.php" );
	$nexmo_sms = new NexmoMessage('ef85bacc', 'f480a5b93a238784');
	$info = $nexmo_sms->sendText( '2348164377187', 'SUG - ATBU 16/17', 'Your SUG Voting CODE - 73422 - Expire - 11/10/2018' );
	//echo $nexmo_sms->displayOverview($info);

	// Done!


?>