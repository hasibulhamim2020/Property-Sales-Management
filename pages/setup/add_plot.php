<?php

session_start();

ob_start();

require "../../support/inc.all.php";



// ::::: Edit This Section :::::



$title='Add Plot';            // Page Name and Page Title

$page="add_plot.php";        // PHP File Name



$table='add_plot';        // Database Table Name Mainly related to this page

$unique='plot_id';            // Primary Key of this Database table

$shown='plot_no';                // For a New or Edit Data a must have data field



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
										$res='select a.plot_id,a.plot_no,b.road_no,c.block_name,d.proj_name from add_plot a, add_road b, add_block c, tbl_project_info d where a.road_id=b.road_id and a.block_id=c.block_id and a.proj_id=d.proj_code';
											

                                            echo $crud->link_report($res,'add_plot.php?plot_id=');?>

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

                                          <label>Plot No :</label>

                                          <input name="<?=$unique?>" id="<?=$unique?>" value="<?=$$unique?>" type="hidden" />

                                          <input name="plot_no" type="text" id="plot_no" value="<?=$plot_no?>">

                                        </div>
										
										<div>
									   <label>Road No:</label>
										  <select name="road_id" id="road_id" value="<?=$road_id?>">
										  
										  <? foreign_relation('add_road','road_id','road_no',$road_id);?>
										 
										  </select>
				   					  </div>
										
										<div>
									   <label>Block Name:</label>
										  <select name="block_id" id="block_id" value="<?=$block_id?>">
										  
										  <? foreign_relation('add_block','block_id','block_name',$block_id);?>
										 
										  </select>
				   					  </div>
										
										 <div>
									 <label>Section Name:</label>
										  <select name="section_id" id="section_id" value="<?=$section_id?>">
										  
										  <? foreign_relation('add_section','section_id','section_name',$section_id);?>
										 
										  </select>
				   					  </div>

										
										<div>

                                          <label>Category Name:</label>
										  <select name="cat_id" id="cat_id" value="<?=$cat_id?>">
										 <?
										 	foreign_relation('add_category','cat_id','cat_name',$cat_id);
											?>
											
										  
										  </select>
									
                                    </div>

                                    <div>
									
									 <label>Project Name:</label>
										  <select name="proj_id" id="proj_id" value="<?=$proj_id?>">
										  
										  <? foreign_relation('tbl_project_info','proj_code','proj_name',$proj_id);?>
										 
										  </select>
										  

                                    </div>
                                   



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