<?
//start ------------------------------------------------------------------------------------------------------------------
  INCLUDE(dirname(__FILE__)."/../../php_script/add_edit_01_start.php");
//start ------------------------------------------------------------------------------------------------------------------

//overright size per etiketat dhe objektet e formes ----------------------------------------------------------------------
  $width_form = 12;
  $width_lab  = 3;
  IF ($width_lab == 12)
     {
      $width_obj = 12; 
     }
  ELSE
     {
      $width_obj = 12 - $width_lab; 
     }
//overright size per etiketat dhe objektet e formes ----------------------------------------------------------------------

IF (ISSET($post_id) AND ($post_id != ""))
   {
    unset($tab);
    $kushti_where        = 'WHERE id_village = "'.ValidateVarFun::f_real_escape_string($post_id).'"';
    $tab['tab_name']     = 'phi_village';            //*emri i tabeles ku do behet select
    $tab['sql_where']    = $kushti_where;           //default = "", kthen gjithe rekordet pa filtrim; perndryshe shkruani kushtin e filtrimit, mos haroni fjalen WHERE;
    $tab['nr_rec_tot']   = 'F';                     //default = "F", (FALSE); pranon vlerat T,F; kur eshte True kthen dhe numrin total te rekordeve qe kthen selekti;
    $tab['kol_filter']   = '';                      //default = ""(bosh); kur i do gjithe kolonat e tabeles lihet bosh; kur nuk te interesojne disa kolona i vendos emrat e kolonave te ndara me presjeve; zakonisht perdoret per te filtruar fushat e tipit blob;
    $tab['kol_select']   = '';                      //default = ""(bosh); kur i do gjithe kolonat e tabeles lihet bosh; kur te interesojne vetem disa kolona i vendos emrat e kolonave te ndara me presjeve;
    $tab['kol_order']    = '';                      //default = "", pra rekordet nuk renditen sipas ndonje kolone; emri i kolones sipas se ciles do renditen rekordet;
    $tab['kol_asc_desc'] = '';                      //default = "ASC"; pranon vlerat ASC, DESC; meret parasysh kur $tab['kol_order'] != "";
    $tab['rec_limit']    = '';                      //default = "", pra pa limit; perndryshe kthen ato rekorde qe jane percaktuar ne limit, formati = 0,10;
    $tab['obj_class']    = '';            		  //default = "txtbox"; emri i klases ne style, vlen kur $tab['is_form'] = "T";
    $tab['distinct']     = 'F';      				  //default = "F" -> pranon vlerat T,F (pra true ose false);
    $tab['is_form']      = 'F';                     //default = "T"; pranon vlerat T,F;
    $val_rec             = f_app_select_form_table($tab);
    
    $upd_record_user      = f_app_record_user ($val_rec['record_user'][0]['vl']);
    $upd_record_timestamp = $val_rec['record_timestamp'][0]['vlf_dt'];
   }

//rights -----------------------------------------------------------------------------------------------------------------
  INCLUDE(dirname(__FILE__)."/../../php_script/add_edit_02_rights.php");
//rights -----------------------------------------------------------------------------------------------------------------

//LOV --------------------------------------------------------------------------------------------------------------------
  //id_municipality ------------------------------------------------------------------------------------------------------
    unset($lov);
    $lov["name"]          = "id_municipality";
    IF ($val_rec['id_municipality'][0]['vl'] != "")
       {
        $lov["id_select"] = $val_rec['id_municipality'][0]['vl'];
       }
    ELSE
       {
        $lov["id_select"] = "-1";
       }
    $lov["object_name"]   = "id_municipality";
    $lov["valid"]         = "1,0,0,0,0,0";
    $lov["only_options"]  = "Y";
    $lov["obj_or_label"]  = $obj_or_label;
  
    $lov_id_municipality  = f_app_lov_default_values($lov);
  //id_municipality ------------------------------------------------------------------------------------------------------

  //id_district ----------------------------------------------------------------------------------------------------------
    unset($lov);
    $lov["name"]          = "id_district";
    IF ($val_rec['id_district'][0]['vl'] != "")
       {
        $lov["id_select"] = $val_rec['id_district'][0]['vl'];
       }
    ELSE
       {
        $lov["id_select"] = "-1";
       }
    $lov["object_name"]   = "id_district";
    $lov["valid"]         = "1,0,0,0,0,0";
    $lov["only_options"]  = "Y";
    $lov["obj_or_label"]  = $obj_or_label;
  
    $lov_id_district      = f_app_lov_default_values($lov);
  //id_district ----------------------------------------------------------------------------------------------------------

  //PER FILTRIMIN E KOMUNAVE ---------------------------------------------------------------------------------------------
    IF ($editim_konsultim == 'editim')
       {
        unset($lov);
        $lov["name"]                 = "id_district_id_commune";
        $lov["obj_or_label"]         = "label";
        $lov["all_data_array"]       = "Y";
        $lov_district_id_commune_arr = f_app_lov_default_values($lov);
        $district_arr_js             = f_app_js_arr($lov_district_id_commune_arr);
        $script_js_in_page .= '
                                f_app_array_js["id_district"] = "'.$district_arr_js.'";
                              ';
       }
  //PER FILTRIMIN E KOMUNAVE ---------------------------------------------------------------------------------------------

  //id_commune -----------------------------------------------------------------------------------------------------------
    unset($lov);
    $lov["name"]          = "id_commune";
    IF ($val_rec['id_commune'][0]['vl'] != "")
       {
        $lov["id_select"] = $val_rec['id_commune'][0]['vl'];
       }
    ELSE
       {
        $lov["id_select"] = "-1";
       }

    IF ($val_rec['id_district'][0]['vl'] != "")
       {
        $lov["filter"] = "WHERE id_district = '".ValidateVarFun::f_real_escape_string($val_rec['id_district'][0]['vl'])."'";
       }

    $lov["object_name"]   = "id_commune";
    $lov["valid"]         = "1,0,0,0,0,0";
    $lov["only_options"]  = "Y";
    $lov["obj_or_label"]  = $obj_or_label;
  
    $lov_id_commune       = f_app_lov_default_values($lov);
  //id_commune -----------------------------------------------------------------------------------------------------------

  //record_status --------------------------------------------------------------------------------------------------------
    unset($lov);
    $lov["name"]          = "record_status";
    IF ($val_rec['record_status'][0]['vl'] != "")
       {
        $lov["id_select"] = $val_rec['record_status'][0]['vl'];
       }
    ELSE
       {
        $lov["id_select"] = "-1";
       }
    $lov["object_name"]   = "record_status";
    $lov["valid"]         = "1,0,0,0,0,0";
    $lov["alert_etiketa"] = "Statusi";
    $lov["null_print"]    = "F";
    $lov["only_options"]  = "Y";
    $lov["obj_or_label"]  = $obj_or_label;
  
    $lov_record_status    = f_app_lov_default_values($lov);
  //record_status --------------------------------------------------------------------------------------------------------
//LOV --------------------------------------------------------------------------------------------------------------------
   
//Grid_form -----------------------------------------------------------------------------------------------------------
  $nr  = -1;
  $Grid_form = array('data' => array(), 'AllRecs' => '0');	

  $nr = $nr + 1;
  $Grid_form['data'][$nr]['type']             = 'form_header';
  $Grid_form['data'][$nr]['label']            = $titull_print;
  $Grid_form['data'][$nr]['data-action']      = '';//collapse

  $nr = $nr + 1;
  $Grid_form['data'][$nr]['type']             = 'form_open';
  $Grid_form['data'][$nr]['name']             = 'skeda';
  $Grid_form['data'][$nr]['id']               = 'id_skeda';
  $Grid_form['data'][$nr]['method']           = 'post';
  $Grid_form['data'][$nr]['onSubmit']         = 'return false;';
  $Grid_form['data'][$nr]['placeholder']      = '';
  $Grid_form['data'][$nr]['other_attributes'] = '';

  $nr = $nr + 1;
  $Grid_form['data'][$nr]['type']             = 'hidden';
  $Grid_form['data'][$nr]['name']             = 'vars_page';
  $Grid_form['data'][$nr]['value']            = $vars_page;
  $Grid_form['data'][$nr]['id']               = '';
  $Grid_form['data'][$nr]['other_attributes'] = '';

  $nr = $nr + 1;
  $Grid_form['data'][$nr]['type']             = 'form_body_start';
  $Grid_form['data'][$nr]['other_attributes'] = '';

  $nr = $nr + 1;
  $Grid_form['data'][$nr]['type']             = 'row_start';
  $Grid_form['data'][$nr]['other_attributes'] = '';

  $nr = $nr + 1;
  $Grid_form['data'][$nr]['type']             = 'col_start';
  $Grid_form['data'][$nr]['width']            = 4;
  $Grid_form['data'][$nr]['other_attributes'] = '';

  //name -----------------------------------------------------------------------------------------------
  $nr = $nr + 1;
  $Grid_form['data'][$nr]['type']             = 'row_start';
  $Grid_form['data'][$nr]['other_attributes'] = '';

  $nr = $nr + 1;
  $Grid_form['data'][$nr]['type']             = 'col_start';
  $Grid_form['data'][$nr]['width']            = $width_form;
  $Grid_form['data'][$nr]['other_attributes'] = '';

  $nr = $nr + 1;
  $Grid_form['data'][$nr]['type']             = 'section_start';
  $Grid_form['data'][$nr]['other_attributes'] = '';

  $nr = $nr + 1;
  $Grid_form['data'][$nr]['type']             = 'label';
  $Grid_form['data'][$nr]['value']            = $yll.'{{emertimi_mesg}}:';
  $Grid_form['data'][$nr]['for']              = 'id_name';
  $Grid_form['data'][$nr]['id']               = 'id_name_label';
  $Grid_form['data'][$nr]['other_attributes'] = '';
  $Grid_form['data'][$nr]['width']            = $width_lab;

  $nr = $nr + 1;
  $Grid_form['data'][$nr]['type']             = $obj_type_text;
  $Grid_form['data'][$nr]['name']             = 'name';
  $Grid_form['data'][$nr]['value']            = HTMLSPECIALCHARS($val_rec['name'][0]['vl']).'';
  $Grid_form['data'][$nr]['id']               = 'id_name';
  $Grid_form['data'][$nr]['placeholder']      = '';
  $Grid_form['data'][$nr]['maxlength']        = '100';
  $Grid_form['data'][$nr]['other_attributes'] = 'valid="1,0,0,0,0,0" etiketa="{{emertimi_mesg}}"';
  $Grid_form['data'][$nr]['width']            = $width_obj;

  $nr = $nr + 1;
  $Grid_form['data'][$nr]['type']             = 'section_end';

  $nr = $nr + 1;
  $Grid_form['data'][$nr]['type']             = 'col_end';

  $nr = $nr + 1;
  $Grid_form['data'][$nr]['type']             = 'row_end';
  //name -----------------------------------------------------------------------------------------------

  //id_municipality ----------------------------------------------------------------------------------------
  $nr = $nr + 1;
  $Grid_form['data'][$nr]['type']             = 'row_start';
  $Grid_form['data'][$nr]['other_attributes'] = '';

  $nr = $nr + 1;
  $Grid_form['data'][$nr]['type']             = 'col_start';
  $Grid_form['data'][$nr]['width']            = 12;
  $Grid_form['data'][$nr]['other_attributes'] = '';

  $nr = $nr + 1;
  $Grid_form['data'][$nr]['type']             = 'section_start';
  $Grid_form['data'][$nr]['other_attributes'] = '';

  $nr = $nr + 1;
  $Grid_form['data'][$nr]['type']             = 'label';
  $Grid_form['data'][$nr]['value']            = $yll.'{{id_municipality_mesg}}:';
  $Grid_form['data'][$nr]['for']              = 'id_municipality';
  $Grid_form['data'][$nr]['id']               = 'id_municipality_label';
  $Grid_form['data'][$nr]['other_attributes'] = '';
  $Grid_form['data'][$nr]['width']            = $width_lab;

  $nr = $nr + 1;
  $Grid_form['data'][$nr]['type']             = $obj_type_select;
  $Grid_form['data'][$nr]['name']             = 'id_municipality';
  $Grid_form['data'][$nr]['value']            = $lov_id_municipality;
  $Grid_form['data'][$nr]['id']               = 'id_id_municipality';
  $Grid_form['data'][$nr]['placeholder']      = '';
  $Grid_form['data'][$nr]['other_attributes'] = 'valid="1,0,0,0,0,0" etiketa="{{id_municipality_mesg}}"';
  $Grid_form['data'][$nr]['width']            = $width_obj;
  $Grid_form['data'][$nr]['filter']           = 'Y';

  $nr = $nr + 1;
  $Grid_form['data'][$nr]['type']             = 'section_end';

  $nr = $nr + 1;
  $Grid_form['data'][$nr]['type']             = 'col_end';

  $nr = $nr + 1;
  $Grid_form['data'][$nr]['type']             = 'row_end';
  //id_district ----------------------------------------------------------------------------------------
  
  //code -----------------------------------------------------------------------------------------------
  $nr = $nr + 1;
  $Grid_form['data'][$nr]['type']             = 'row_start';
  $Grid_form['data'][$nr]['other_attributes'] = '';

  $nr = $nr + 1;
  $Grid_form['data'][$nr]['type']             = 'col_start';
  $Grid_form['data'][$nr]['width']            = $width_form;
  $Grid_form['data'][$nr]['other_attributes'] = '';

  $nr = $nr + 1;
  $Grid_form['data'][$nr]['type']             = 'section_start';
  $Grid_form['data'][$nr]['other_attributes'] = '';

  $nr = $nr + 1;
  $Grid_form['data'][$nr]['type']             = 'label';
  $Grid_form['data'][$nr]['value']            = '{{code_mesg}}:';
  $Grid_form['data'][$nr]['for']              = 'id_code';
  $Grid_form['data'][$nr]['id']               = 'id_code_label';
  $Grid_form['data'][$nr]['other_attributes'] = '';
  $Grid_form['data'][$nr]['width']            = $width_lab;

  $nr = $nr + 1;
  $Grid_form['data'][$nr]['type']             = $obj_type_text;
  $Grid_form['data'][$nr]['name']             = 'code';
  $Grid_form['data'][$nr]['value']            = HTMLSPECIALCHARS($val_rec['code'][0]['vl']).'';
  $Grid_form['data'][$nr]['id']               = 'id_code';
  $Grid_form['data'][$nr]['placeholder']      = '';
  $Grid_form['data'][$nr]['maxlength']        = '30';
  $Grid_form['data'][$nr]['other_attributes'] = 'valid="0,0,0,0,0,0" etiketa="{{code_mesg}}"';
  $Grid_form['data'][$nr]['width']            = $width_obj;

  $nr = $nr + 1;
  $Grid_form['data'][$nr]['type']             = 'section_end';

  $nr = $nr + 1;
  $Grid_form['data'][$nr]['type']             = 'col_end';

  $nr = $nr + 1;
  $Grid_form['data'][$nr]['type']             = 'row_end';
  //code -----------------------------------------------------------------------------------------------
  
  $nr = $nr + 1;
  $Grid_form['data'][$nr]['type']             = 'col_end';
  
  $nr = $nr + 1;
  $Grid_form['data'][$nr]['type']             = 'col_start';
  $Grid_form['data'][$nr]['width']            = 4;
  $Grid_form['data'][$nr]['other_attributes'] = '';
  
  //longtitude -----------------------------------------------------------------------------------------
  $nr = $nr + 1;
  $Grid_form['data'][$nr]['type']             = 'row_start';
  $Grid_form['data'][$nr]['other_attributes'] = '';

  $nr = $nr + 1;
  $Grid_form['data'][$nr]['type']             = 'col_start';
  $Grid_form['data'][$nr]['width']            = $width_form;
  $Grid_form['data'][$nr]['other_attributes'] = '';

  $nr = $nr + 1;
  $Grid_form['data'][$nr]['type']             = 'section_start';
  $Grid_form['data'][$nr]['other_attributes'] = '';

  $nr = $nr + 1;
  $Grid_form['data'][$nr]['type']             = 'label';
  $Grid_form['data'][$nr]['value']            = '{{longtitude_mesg}}:';
  $Grid_form['data'][$nr]['for']              = 'id_longtitude';
  $Grid_form['data'][$nr]['id']               = 'id_longtitude_label';
  $Grid_form['data'][$nr]['other_attributes'] = '';
  $Grid_form['data'][$nr]['width']            = $width_lab;

  $nr = $nr + 1;
  $Grid_form['data'][$nr]['type']             = $obj_type_text;
  $Grid_form['data'][$nr]['name']             = 'longtitude';
  $Grid_form['data'][$nr]['value']            = HTMLSPECIALCHARS($val_rec['longtitude'][0]['vl']).'';
  $Grid_form['data'][$nr]['id']               = 'id_longtitude';
  $Grid_form['data'][$nr]['placeholder']      = '';
  $Grid_form['data'][$nr]['maxlength']        = '20';
  $Grid_form['data'][$nr]['other_attributes'] = 'valid="0,0,0,0,0,0" etiketa="{{longtitude_mesg}}"';
  $Grid_form['data'][$nr]['width']            = $width_obj;

  $nr = $nr + 1;
  $Grid_form['data'][$nr]['type']             = 'section_end';

  $nr = $nr + 1;
  $Grid_form['data'][$nr]['type']             = 'col_end';

  $nr = $nr + 1;
  $Grid_form['data'][$nr]['type']             = 'row_end';
  //longtitude -----------------------------------------------------------------------------------------

  //latitude -----------------------------------------------------------------------------------------
  $nr = $nr + 1;
  $Grid_form['data'][$nr]['type']             = 'row_start';
  $Grid_form['data'][$nr]['other_attributes'] = '';

  $nr = $nr + 1;
  $Grid_form['data'][$nr]['type']             = 'col_start';
  $Grid_form['data'][$nr]['width']            = $width_form;
  $Grid_form['data'][$nr]['other_attributes'] = '';

  $nr = $nr + 1;
  $Grid_form['data'][$nr]['type']             = 'section_start';
  $Grid_form['data'][$nr]['other_attributes'] = '';

  $nr = $nr + 1;
  $Grid_form['data'][$nr]['type']             = 'label';
  $Grid_form['data'][$nr]['value']            = '{{latitude_mesg}}:';
  $Grid_form['data'][$nr]['for']              = 'id_latitude';
  $Grid_form['data'][$nr]['id']               = 'id_latitude_label';
  $Grid_form['data'][$nr]['other_attributes'] = '';
  $Grid_form['data'][$nr]['width']            = $width_lab;

  $nr = $nr + 1;
  $Grid_form['data'][$nr]['type']             = $obj_type_text;
  $Grid_form['data'][$nr]['name']             = 'latitude';
  $Grid_form['data'][$nr]['value']            = HTMLSPECIALCHARS($val_rec['latitude'][0]['vl']).'';
  $Grid_form['data'][$nr]['id']               = 'id_latitude';
  $Grid_form['data'][$nr]['placeholder']      = '';
  $Grid_form['data'][$nr]['maxlength']        = '20';
  $Grid_form['data'][$nr]['other_attributes'] = 'valid="0,0,0,0,0,0" etiketa="{{latitude_mesg}}"';
  $Grid_form['data'][$nr]['width']            = $width_obj;

  $nr = $nr + 1;
  $Grid_form['data'][$nr]['type']             = 'section_end';

  $nr = $nr + 1;
  $Grid_form['data'][$nr]['type']             = 'col_end';

  $nr = $nr + 1;
  $Grid_form['data'][$nr]['type']             = 'row_end';
  //latitude -----------------------------------------------------------------------------------------

  //altitude -----------------------------------------------------------------------------------------
  $nr = $nr + 1;
  $Grid_form['data'][$nr]['type']             = 'row_start';
  $Grid_form['data'][$nr]['other_attributes'] = '';

  $nr = $nr + 1;
  $Grid_form['data'][$nr]['type']             = 'col_start';
  $Grid_form['data'][$nr]['width']            = $width_form;
  $Grid_form['data'][$nr]['other_attributes'] = '';

  $nr = $nr + 1;
  $Grid_form['data'][$nr]['type']             = 'section_start';
  $Grid_form['data'][$nr]['other_attributes'] = '';

  $nr = $nr + 1;
  $Grid_form['data'][$nr]['type']             = 'label';
  $Grid_form['data'][$nr]['value']            = '{{altitude_mesg}}:';
  $Grid_form['data'][$nr]['for']              = 'id_altitude';
  $Grid_form['data'][$nr]['id']               = 'id_altitude_label';
  $Grid_form['data'][$nr]['other_attributes'] = '';
  $Grid_form['data'][$nr]['width']            = $width_lab;

  $nr = $nr + 1;
  $Grid_form['data'][$nr]['type']             = $obj_type_text;
  $Grid_form['data'][$nr]['name']             = 'altitude';
  $Grid_form['data'][$nr]['value']            = HTMLSPECIALCHARS($val_rec['altitude'][0]['vl']).'';
  $Grid_form['data'][$nr]['id']               = 'id_altitude';
  $Grid_form['data'][$nr]['placeholder']      = '';
  $Grid_form['data'][$nr]['maxlength']        = '20';
  $Grid_form['data'][$nr]['other_attributes'] = 'valid="0,0,0,0,0,0" etiketa="{{altitude_mesg}}"';
  $Grid_form['data'][$nr]['width']            = $width_obj;

  $nr = $nr + 1;
  $Grid_form['data'][$nr]['type']             = 'section_end';

  $nr = $nr + 1;
  $Grid_form['data'][$nr]['type']             = 'col_end';

  $nr = $nr + 1;
  $Grid_form['data'][$nr]['type']             = 'row_end';
  //altitude -----------------------------------------------------------------------------------------

  $nr = $nr + 1;
  $Grid_form['data'][$nr]['type']             = 'col_end';
  
  $nr = $nr + 1;
  $Grid_form['data'][$nr]['type']             = 'col_start';
  $Grid_form['data'][$nr]['width']            = 4;
  $Grid_form['data'][$nr]['other_attributes'] = '';
  
  
  //id_district ----------------------------------------------------------------------------------------
  $nr = $nr + 1;
  $Grid_form['data'][$nr]['type']             = 'row_start';
  $Grid_form['data'][$nr]['other_attributes'] = '';

  $nr = $nr + 1;
  $Grid_form['data'][$nr]['type']             = 'col_start';
  $Grid_form['data'][$nr]['width']            = $width_form;
  $Grid_form['data'][$nr]['other_attributes'] = '';

  $nr = $nr + 1;
  $Grid_form['data'][$nr]['type']             = 'section_start';
  $Grid_form['data'][$nr]['other_attributes'] = '';

  $nr = $nr + 1;
  $Grid_form['data'][$nr]['type']             = 'label';
  $Grid_form['data'][$nr]['value']            = $yll.'{{id_district_mesg}}:';
  $Grid_form['data'][$nr]['for']              = 'id_district';
  $Grid_form['data'][$nr]['id']               = 'id_district_label';
  $Grid_form['data'][$nr]['other_attributes'] = '';
  $Grid_form['data'][$nr]['width']            = $width_lab;

  $nr = $nr + 1;
  $Grid_form['data'][$nr]['type']             = $obj_type_select;
  $Grid_form['data'][$nr]['name']             = 'id_district';
  $Grid_form['data'][$nr]['value']            = $lov_id_district;
  $Grid_form['data'][$nr]['id']               = 'id_id_district';
  $Grid_form['data'][$nr]['placeholder']      = '';
  $Grid_form['data'][$nr]['other_attributes'] = 'valid="1,0,0,0,0,0" etiketa="{{id_district_mesg}}" onchange="f_app_filter_listbox(this.id)" js_data_array="id_district" id_obj_child="id_id_commune"';
  $Grid_form['data'][$nr]['width']            = $width_obj;
  $Grid_form['data'][$nr]['filter']           = 'Y';

  $nr = $nr + 1;
  $Grid_form['data'][$nr]['type']             = 'section_end';

  $nr = $nr + 1;
  $Grid_form['data'][$nr]['type']             = 'col_end';

  $nr = $nr + 1;
  $Grid_form['data'][$nr]['type']             = 'row_end';
  //id_district ----------------------------------------------------------------------------------------

  //id_commune -----------------------------------------------------------------------------------------
  $nr = $nr + 1;
  $Grid_form['data'][$nr]['type']             = 'row_start';
  $Grid_form['data'][$nr]['other_attributes'] = '';

  $nr = $nr + 1;
  $Grid_form['data'][$nr]['type']             = 'col_start';
  $Grid_form['data'][$nr]['width']            = $width_form;
  $Grid_form['data'][$nr]['other_attributes'] = '';

  $nr = $nr + 1;
  $Grid_form['data'][$nr]['type']             = 'section_start';
  $Grid_form['data'][$nr]['other_attributes'] = '';

  $nr = $nr + 1;
  $Grid_form['data'][$nr]['type']             = 'label';
  $Grid_form['data'][$nr]['value']            = $yll.'{{id_commune_mesg}}:';
  $Grid_form['data'][$nr]['for']              = 'id_commune';
  $Grid_form['data'][$nr]['id']               = 'id_commune_label';
  $Grid_form['data'][$nr]['other_attributes'] = '';
  $Grid_form['data'][$nr]['width']            = $width_lab;

  $nr = $nr + 1;
  $Grid_form['data'][$nr]['type']             = $obj_type_select;
  $Grid_form['data'][$nr]['name']             = 'id_commune';
  $Grid_form['data'][$nr]['value']            = $lov_id_commune;
  $Grid_form['data'][$nr]['id']               = 'id_id_commune';
  $Grid_form['data'][$nr]['placeholder']      = '';
  $Grid_form['data'][$nr]['other_attributes'] = 'valid="1,0,0,0,0,0" etiketa="{{id_commune_mesg}}"';
  $Grid_form['data'][$nr]['width']            = $width_obj;
  $Grid_form['data'][$nr]['filter']           = 'Y';

  $nr = $nr + 1;
  $Grid_form['data'][$nr]['type']             = 'section_end';

  $nr = $nr + 1;
  $Grid_form['data'][$nr]['type']             = 'col_end';

  $nr = $nr + 1;
  $Grid_form['data'][$nr]['type']             = 'row_end';
  //id_commune -----------------------------------------------------------------------------------------

  $nr = $nr + 1;
  $Grid_form['data'][$nr]['type']             = 'col_end';

  $nr = $nr + 1;
  $Grid_form['data'][$nr]['type']             = 'row_end';

  //statusi --------------------------------------------------------------------------------------------
  $nr = $nr + 1;
  $Grid_form['data'][$nr]['type']             = 'row_start';
  $Grid_form['data'][$nr]['other_attributes'] = '';

  $nr = $nr + 1;
  $Grid_form['data'][$nr]['type']             = 'col_start';
  $Grid_form['data'][$nr]['width']            = 4;
  $Grid_form['data'][$nr]['other_attributes'] = '';

  $nr = $nr + 1;
  $Grid_form['data'][$nr]['type']             = 'section_start';
  $Grid_form['data'][$nr]['other_attributes'] = '';

  $nr = $nr + 1;
  $Grid_form['data'][$nr]['type']             = 'label';
  $Grid_form['data'][$nr]['value']            = $yll.'{{statusi_mesg}}:';
  $Grid_form['data'][$nr]['for']              = 'record_status';
  $Grid_form['data'][$nr]['id']               = 'id_record_status_label';
  $Grid_form['data'][$nr]['other_attributes'] = '';
  $Grid_form['data'][$nr]['width']            = $width_lab;

  $nr = $nr + 1;
  $Grid_form['data'][$nr]['type']             = $obj_type_select;
  $Grid_form['data'][$nr]['name']             = 'record_status';
  $Grid_form['data'][$nr]['value']            = $lov_record_status;
  $Grid_form['data'][$nr]['id']               = 'id_record_status';
  $Grid_form['data'][$nr]['placeholder']      = '';
  $Grid_form['data'][$nr]['other_attributes'] = 'valid="1,0,0,0,0,0" etiketa="{{statusi_mesg}}"';
  $Grid_form['data'][$nr]['width']            = $width_obj;

  $nr = $nr + 1;
  $Grid_form['data'][$nr]['type']             = 'section_end';

  $nr = $nr + 1;
  $Grid_form['data'][$nr]['type']             = 'col_end';

  $nr = $nr + 1;
  $Grid_form['data'][$nr]['type']             = 'row_end';
  //statusi ----------------------------------------------------------------------------------------

  $nr = $nr + 1;
  $Grid_form['data'][$nr]['type']             = 'form_body_end';

  //buttons --------------------------------------------------------------------------------------------------------------
    INCLUDE(dirname(__FILE__)."/../../php_script/add_edit_03_buttons.php");
  //buttons --------------------------------------------------------------------------------------------------------------
  
  $nr = $nr + 1;
  $Grid_form['data'][$nr]['type']             = 'form_closed';

  //audit trail ----------------------------------------------------------------------------------------------------------
    INCLUDE(dirname(__FILE__)."/../../php_script/add_edit_04_audit_trail.php");
  //audit trail ----------------------------------------------------------------------------------------------------------

  //end ------------------------------------------------------------------------------------------------------------------
    INCLUDE(dirname(__FILE__)."/../../php_script/add_edit_05_end.php");
  //end ------------------------------------------------------------------------------------------------------------------
//Grid_form --------------------------------------------------------------------------------------------------------------
?>