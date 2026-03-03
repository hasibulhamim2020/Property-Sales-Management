<?php
session_start();
ob_start();
require "../../support/inc.all.php";
$title='Project Info';
?>


<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><div class="box2">
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td><table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
                <tr>
                  <td>Project  :</td>
                  <td><select name="project" id="project">
                    <option  value="Category">Category</option>
                    <option  value="Category">Category</option>
                    <option  value="Category">Category</option>
                    <option  value="Category">Category</option>
                  </select></td>
                </tr>
                <tr>
                  <td>Builings: </td>
                  <td><select name="select" id="select">
                    <option  value="Category">Category</option>
                    <option  value="Category">Category</option>
                    <option  value="Category">Category</option>
                    <option  value="Category">Category</option>
                  </select></td>
                </tr>
                <tr>
                  <td>Flat Type : </td>
                  <td><select name="select2" id="select2">
                    <option  value="Category">Category</option>
                    <option  value="Category">Category</option>
                    <option  value="Category">Category</option>
                    <option  value="Category">Category</option>
                  </select></td>
                </tr>
              </table></td>
            </tr>
            <tr>
              <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td>Flat No.: </td>
                  <td><input  name="code2" type="text" value=""/></td>
                  <td>New No.: </td>
                  <td><input  name="code22" type="text" value=""/></td>
                </tr>
                <tr>
                  <td>Flat size: </td>
                  <td><input  name="code23" type="text" value=""/></td>
                  <td>Facing</td>
                  <td><input  name="code24" type="text" value=""/></td>
                </tr>
                <tr>
                  <td>Floor No. </td>
                  <td><input  name="code25" type="text" value=""/></td>
                  <td>Status:</td>
                  <td><input  name="code26" type="text" value=""/></td>
                </tr>
                <tr>
                  <td>Grage No.: </td>
                  <td><input  name="code27" type="text" value=""/></td>
                  <td>Rate/Sqft:</td>
                  <td><input  name="code28" type="text" value=""/></td>
                </tr>
              </table></td>
            </tr>
            <tr>
              <td>&nbsp;</td>
            </tr>
          </table></td>
          <td valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
            <tr>
              <td>Client Details: </td>
              <td><input  name="code29" type="text" value=""/></td>
            </tr>
            <tr>
              <td>Utility Charge: </td>
              <td><input  name="name" type="text" value=""/></td>
            </tr>
            <tr>
              <td>Additional Charge: </td>
              <td><input  name="brief" type="text" value=""/></td>
            </tr>
            <tr>
              <td>Reg. Charge    : </td>
              <td><input  name="brief" type="text" value=""/></td>
            </tr>
            <tr>
              <td>Other Charge    : </td>
              <td><input  name="brief" type="text" value=""/></td>
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
    <td><div class="box4">
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td><div class="box1">
                    <table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
                      <tr>
                        <td>Client Details: </td>
                        <td><input  name="name2" type="text" value=""/></td>
                      </tr>
                      <tr>
                        <td>Utility Charge: </td>
                        <td><input  name="name" type="text" value=""/></td>
                      </tr>
                      <tr>
                        <td>Additional Charge: </td>
                        <td><input  name="brief" type="text" value=""/></td>
                      </tr>
                      <tr>
                        <td>Reg. Charge    : </td>
                        <td><input  name="brief" type="text" value=""/></td>
                      </tr>
                      <tr>
                        <td>Other Charge    : </td>
                        <td><input  name="brief" type="text" value=""/></td>
                      </tr>
                    </table>
                  </div></td>
                </tr>
              </table></td>
              <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td class="title1"><div align="left">Payment Details </div></td>
                </tr>
                <tr>
                  <td><div align="left">
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td><div align="left">Payment Head </div></td>
                        <td><div align="left">Amount</div></td>
                      </tr>
                      <tr>
                        <td><select name="select3" id="select3">
                          <option  value="Category">Category</option>
                          <option  value="Category">Category</option>
                          <option  value="Category">Category</option>
                          <option  value="Category">Category</option>
                        </select></td>
                        <td><input  name="code222" type="text" value=""/></td>
                      </tr>
                    </table>
                  </div></td>
                </tr>
                <tr>
                  <td><div class="tabledesign2">
                    <table cellspacing="0" cellpadding="0" width="100%">
                      <tr>
                        <th>Code</th>
                        <th>Description</th>
                        <th>Amount </th>
                      </tr>
                      <tr class="alt">
                        <td>Demo text</td>
                        <td>Demo text</td>
                        <td>Demo text</td>
                      </tr>
                      <tr>
                        <td>Demo text
                                    </th>
                        <td>Demo text</td>
                        <td>Demo text</td>
                      </tr>
                      <tr class="alt">
                        <td>Demo text</td>
                        <td>Demo text</td>
                        <td>Demo text</td>
                      </tr>
                      <tr>
                        <td>Demo text
                                    </th>
                        <td>Demo text</td>
                        <td>Demo text</td>
                      </tr>
                      <tr class="alt">
                        <td>Demo text</td>
                        <td>Demo text</td>
                        <td>Demo text</td>
                      </tr>
                    </table>
                  </div></td>
                </tr>
              </table></td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td><div class="box">
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td><input type="submit" value="Update" class="btn" /></td>
                <td><input type="submit" value="Save" class="btn" /></td>
                <td><input type="submit" value="Cancle" class="btn" /></td>
                <td><input type="submit" value="Close" class="btn" /></td>
              </tr>
            </table>
          </div></td>
        </tr>
      </table>
    </div></td>
  </tr>
</table>
<?
$main_content=ob_get_contents();
ob_end_clean();
include ("../../template/main_layout.php");
?>