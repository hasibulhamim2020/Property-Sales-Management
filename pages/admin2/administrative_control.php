<?php
session_start();
ob_start();
require "../../support/inc.all.php";
$title='Project Info';

//echo $proj_id;
?>

<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><div class="box2">
      <table width="42%" border="0" cellspacing="0" cellpadding="0" align="center">
        <tr>
          <td>User ID  :</td>
          <td><input  name="code" type="text" value=""/></td>
        </tr>
        <tr>
          <td>User Name : </td>
          <td><input  name="name" type="text" value=""/></td>
        </tr>
        <tr>
          <td>Password : </td>
          <td><input  name="brief" type="text" value=""/></td>
        </tr>
      </table>
    </div></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><div class="box4">
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td class="title1"><div align="left">Module Name </div></td>
            </tr>
            <tr>
              <td><div class="box1">
                <div class="tabledesign2">
                  <table cellspacing="0" cellpadding="0" width="100%">
                    <tr>
                      <th>Cbomod</th>
                    </tr>
                    <tr class="alt">
                      <td>01. Admin Controm </td>
                    </tr>
                    <tr>
                      <td>02. Setup Option 	
                    </tr>
                    <tr class="alt">
                      <td>03.</td>
                    </tr>
                    <tr>
                      <td>04.	 
                    </tr>
                    <tr class="alt">
                      <td>05.</td>
                    </tr>
                  </table>
                </div>
              </div></td>
            </tr>
            <tr>
              <td><div class="box3">
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td><input name="submit" type="submit" class="btn1" value="Save" /></td>
                    <td><input name="submit2" type="submit" class="btn1" value="Update" /></td>
                  </tr>
                  <tr>
                    <td><input name="submit22" type="submit" class="btn1" value="Delete" /></td>
                    <td><input name="submit23" type="submit" class="btn1" value="Browse" /></td>
                  </tr>
                  <tr>
                    <td><input name="submit22" type="submit" class="btn1" value="Exit" /></td>
                    <td>&nbsp;</td>
                  </tr>
                </table>
              </div></td>
            </tr>
          </table></td>
          <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td class="title1"><div align="left">Module Option</div></td>
            </tr>
            <tr>
              <td><div class="tabledesign1">
                <table cellspacing="0" cellpadding="0" width="100%">
                  <tr>
                    <th>MID</th>
                    <th>SID</th>
                    <th>Function Name </th>
                    <th>Allow</th>
                  </tr>
                  <tr class="alt">
                    <td>Demo text</td>
                    <td>Demo text</td>
                    <td>Demo text</td>
                    <td>Demo text</td>
                  </tr>
                  <tr>
                    <td>Demo text
                              </th>
                    <td>Demo text</td>
                    <td>Demo text</td>
                    <td>Demo text</td>
                  </tr>
                  <tr class="alt">
                    <td>Demo text</td>
                    <td>Demo text</td>
                    <td>Demo text</td>
                    <td>Demo text</td>
                  </tr>
                  <tr>
                    <td>Demo text
                              </th>
                    <td>Demo text</td>
                    <td>Demo text</td>
                    <td>Demo text</td>
                  </tr>
                  <tr class="alt">
                    <td>Demo text</td>
                    <td>Demo text</td>
                    <td>Demo text</td>
                    <td>Demo text</td>
                  </tr>
                  <tr>
                    <td>Demo text
                              </th>
                    <td>Demo text</td>
                    <td>Demo text</td>
                    <td>Demo text</td>
                  </tr>
                  <tr class="alt">
                    <td>Demo text</td>
                    <td>Demo text</td>
                    <td>Demo text</td>
                    <td>Demo text</td>
                  </tr>
                  <tr>
                    <td>Demo text
                              </th>
                    <td>Demo text</td>
                    <td>Demo text</td>
                    <td>Demo text</td>
                  </tr>
                  <tr class="alt">
                    <td>Demo text</td>
                    <td>Demo text</td>
                    <td>Demo text</td>
                    <td>Demo text</td>
                  </tr>
                  <tr>
                    <td>Demo text
                              </th>
                    <td>Demo text</td>
                    <td>Demo text</td>
                    <td>Demo text</td>
                  </tr>
                  <tr class="alt">
                    <td>Demo text</td>
                    <td>Demo text</td>
                    <td>Demo text</td>
                    <td>Demo text</td>
                  </tr>
                  <tr>
                    <td>Demo text
                              </th>
                    <td>Demo text</td>
                    <td>Demo text</td>
                    <td>Demo text</td>
                  </tr>
                </table>
              </div></td>
            </tr>
          </table></td>
        </tr>
      </table>
    </div></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
<?
$main_content=ob_get_contents();
ob_end_clean();
include ("../../template/main_layout.php");
?>