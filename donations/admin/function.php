<?php 

function print_form() {

  echo '

 <TABLE style="width:600px">

  <TR><TD>

    <CENTER>

     <FORM ACTION="" METHOD="post" name="donations"><br />

	 <h2>Add Cash Points</h2><br><br>

	 <label><input type="text" name="accountid" id="accountid" value="Account ID:" ></label>

	 <label><input type="text" name="amount" id="amount" value="Amount:" ></label><br>

     <label> <input type="submit" name="AddDonations" OnClick="" value="Add Cash Points"></label>

     </FORM><br /><br />

    </CENTER>

	</TR></TD>

	</TABLE>

  ';

}
?>