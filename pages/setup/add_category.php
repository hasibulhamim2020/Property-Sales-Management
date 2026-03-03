<?php

session_start();

ob_start();

require "../../support/inc.all.php";



// ::::: Edit This Section :::::



$title='Add Category';            // Page Name and Page Title

$page="add_category.php";        // PHP File Name



$table='add_category';        // Database Table Name Mainly related to this page

$unique='cat_id';            // Primary Key of this Database table

$shown='cat_name';                // For a New or Edit Data a must have data field



// ::::: End Edit Section :::::



//if(isset($_GET['proj_code'])) $proj_code=$_GET[$proj_code];

$crud      =new crud($table);



$$unique = $_GET[$unique];

if(isset($_POST[$shown]))

{

$$unique = $_POST[$unique];



if(isset($_POST['insert']))

{

 $proj_id            = $_SESSION['proj_id'];

$now                = time();





$crud->insert();

$type=1;

$msg='New Entry Successfully Inserted.';

unset($_POST);

unset($$unique);

}





//for Modify..................................



if(isset($_POST['update']))

{



        $crud->update($unique);

        $type=1;

        $msg='Successfully Updated.';

}

//for Delete..................................



if(isset($_POST['delete']))

{        $condition=$unique."=".$$unique;        $crud->delete($condition);

        unset($$unique);

        $type=1;

        $msg='Successfully Deleted.';

}

}



if(isset($$unique))

{

$condition=$unique."=".$$unique;

$data=db_fetch_object($table,$condition);

while (list($key, $value)=each($data))

{ $$key=$value;}

}

if(!isset($$unique)) $$unique=db_last_insert_id($table,$unique);



?>



<script type="text/javascript"> function DoNav(lk){document.location.href = '<?=$page?>?<?=$unique?>='+lk;}



function popUp(URL)

{

day = new Date();

id = day.getTime();

eval("page" + id + " = window.open(URL, '" + id + "', 'toolbar=0,scrollbars=1,location=0,statusbar=1,menubar=0,resizable=1,width=800,height=800,left = 383,top = -16');");

}

</script>

<div class="form-container_large">

<table width="100%" border="0" cellspacing="0" cellpadding="0">

  <tr>

    <td valign="top"><div class="left">

                            <table width="100%" border="0" cellspacing="0" cellpadding="0">



                                  <tr>

                                    <td>&nbsp;</td>

                                  </tr>

                                  <tr>

                                    <td>

                                    <div class="tabledesign">

                                     <?
									$res="select cat_id,cat_id,cat_name from add_category ";
									
                                            echo $crud->link_report($res,'add_category.php?cat_id=');?>

                                    </div><?=paging(50);?></td>

                              </tr>

                                </table>



                            </div></td>

    <td valign="top"><form action="" method="post" enctype="multipart/form-data" name="form1" id="form1">



      <table width="100%" border="0" cellspacing="0" cellpadding="0">

                            <tr>

                              <td>

                                <table width="100%" border="0" cellspacing="0" cellpadding="0">

                                  <tr>

                                    <td>

                                    <fieldset>

                                        <legend><?=$title?></legend>



                                        <div> </div>

                                        <div class="buttonrow"></div>







                                        <div>

                                          <label>Category Name :</label>

                                          <input name="<?=$unique?>" id="<?=$unique?>" value="<?=$$unique?>" type="hidden" />

                                          <input name="cat_name" type="text" id="cat_name" value="<?=$cat_name?>">

                                        </div>
										
										
                                   <?php /*?><div>

                                          <label>Project Name:</label>
										  <select name="proj_id" id="proj_id" value="<?=$proj_id?>">
										 <?
										 	foreign_relation('tbl_project_info','proj_code','proj_name',$proj_id);
											?>
											
										  
										  </select>
									
                                    </div>
<?php */?>

                                    </fieldset>                                    </td>

                                  </tr>



                                </table></td>

                                </tr>





                            <tr>

                              <td>

                                <table width="100%" border="0" cellspacing="0" cellpadding="0">

                                    <tr>

                                      <td>

                                      <div class="button">

                                        <? if(!isset($_GET[$unique])){?>

                                        <input name="insert" type="submit" id="insert" value="Save" class="btn" />

                                        <? }?>

                                        </div>                                        </td>

                                        <td>

                                        <div class="button">

                                        <? if(isset($_GET[$unique])){?>

                                        <input name="update" type="submit" id="update" value="Update" class="btn" />

                                        <? }?>

                                        </div>                                    </td>

                                      <td>

                                      <div class="button">

                                      <input name="reset" type="button" class="btn" id="reset" value="Reset" onclick="parent.location='<?=$page?>'" />

                                      </div>                                      </td>

                                      <td>

                                      <div class="button">

                                      <input class="btn" name="delete" type="submit" id="delete" value="Delete"/>

                                      </div>                                      </td>

                                    </tr>

                                </table></td>

                            </tr>

        </table>

    </form></td>

  </tr>

</table>

</div>

<?

$main_content=ob_get_contents();

ob_end_clean();

include ("../../template/main_layout.php");

?>