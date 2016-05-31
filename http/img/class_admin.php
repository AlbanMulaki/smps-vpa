<?php

require '/srv/http/vpauni/sis/thrdparty/pdf/examples/tcpdf_include.php';

class admin_obj{
    
    
##################################
## Action: Generate ID Student  ##
## Last Update: 14-11-2013      ##
##                              ##
##                              ##
##################################

    function generate_id() {
        global $root, $cache;

        $last_id = $root->query("SELECT User FROM student ORDER BY `User` DESC LIMIT 1");

        $id = $last_id[0]['User'] + 1;
        return $id;
    }

    function generate_lendet() {
        global $root;
        $lendet = $root->fetch_assoc("Landa", array("id", "Lendet", "Drejtimi", "Semestri"));

        return $lendet;
    }

##################################
## Action:Regjistron studentin  ##
## Last Update: 13-11-2013      ##
##                              ##
##                              ##
##################################

    function add_student($info) {
        global $root;
        $col = array("User",
            "Emri",
            "Mbiemri",
            "Emri Prindit",
            "Mbiemri Prindit",
            "Gjinia",
            "Vendilindjes",
            "Datelindja",
            "Adressa",
            "Vendbanimi",
            "Shteti",
            "Kombesia",
            "Telefoni",
            "Email",
            "Nr Personal",
            "password",
            "Grupi",
            "Data regjistrimit",
            "Niveli",
            "Statusi",
            "Drejtimi",
            "Kualifikimi",
            "Semestri",
            "Shuma",
            "avatar",
            "Transfer",
            "viti_aka");

//$info['kualifikmi'] munges
        $val = array($info['id'],
            $info['emri'],
            $info['mbiemri'],
            $info['emri_prindit'],
            $info['mbiemri_prindit'],
            $info['gjinia'],
            $info['vendlindja'],
            $info['datalindjes'],
            $info['addressa'],
            $info['vendbanimi'],
            $info['shteti'],
            $info['kombesia'],
            $info['telefoni'],
            $info['email'],
            $info['nrpersonal'],
            md5($info['nrpersonal']),
            0,
            date("Y-m-d"),
            $info['niveli'],
            $info['statusi'],
            $info['drejtimi'],
            $info['kualifikimi'],
            $info['semestri'],
            $info['pagesa'],
            "avatar.png",
            $info['transfer'],
            $info['vitiak']
        );
        $root->insert_data("student", $col, $val);
        $root->query("INSERT INTO `pagesat` VALUES (NULL,'" . $info['id'] . "','11111111','" . $info['pershkrimipageses'] . "','" . date("Y-m-d") . "','" . $info['pagoi'] . "' )");

    }

##################################
## Action: Select Student       ##
## Last Update:13-11-2013       ##
##                              ##
##                              ##
##################################

    function convert_student_user($user) {
        global $root;
        $query = $root->query("SELECT Emri,Mbiemri FROM `student` WHERE User = '" . $user . "'");
        $list = implode(" ", $query[0]);

        return $list;
    }

    function check_paraqitjen() {
        global $root, $uni;
        $sql = "SELECT * FROM notat WHERE Paraqitja = 1";
        $paraqitja = $root->query($sql);
        $i = 0;
        foreach ($paraqitja as $array) {
            $landa = $uni->idl($array['idl']);
            $paraqitja[$i]['emril'] = $landa[0]['Lendet'];
            $paraqitja[$i]['Emri'] = self::convert_user($array['Studenti']);
            $i++;
        }
        return

                $paraqitja;
    }

    function allow_paraqitjen($array) {
        global $root;
        foreach ($array as $value) {
            $info = explode("-", $value);

            $root->query("UPDATE notat SET Paraqitja = 2 WHERE idl = '" . $info [1] . "' AND Studenti = '" . $info[0] . "'");
        }

        return TRUE;
    }

    function settings() {
        global $root;
        return $root->fetch_assoc("settings", array
                    ("*"));
    }

    function fix_settings($info) {
        global $root;
        $sql = "UPDATE settings SET provim = '" . $info ['provimi'] . "', lzg = '" . $info ['lzg'] . "', refuzimi ='" . $info['ref'] . "' ";
        echo $sql;
        $root->query($sql);
    }

    function add_afatiprovimit($info) {
        global $root;
        $sql = "INSERT INTO afati_provimev (idl,Prof,Data,Koha,Semestri,Drejtimi,Viti,Session) VALUES ('" . $info['lenda'] . "','" . $info['professori'] . "','" . $info['data'] . "','" . $info['ora'] . "','" . $info['semestri'] . "','" . $info['drejtimi'] . "','" . date('Y') . "','" . date('m') . "')";
        echo $sql;
        $root->query($sql);

        return TRUE;
    }

    function edit_afatiprovimit($id) {
        global $root;
        $afati = $root->query("SELECT * FROM `afati_provimev` WHERE id = '" . $id . "'");
        $i = 0;

        foreach ($afati as $id => $val) {
            $afati[0] ['Koha'] = substr($val['Koha'], 0, 5);
            $i++;
        }

        return $afati;
    }

    function update_afatiprovimit($upd) {
        global $root;
        $upd = inputs($upd);

        $sql = "UPDATE `afati_provimev` SET `Drejtimi` = '" . $upd['drejtimi'] . "' , `idl` = '" . $upd ['lenda'] . "' , `Prof` = '" . $upd['professori'] . "', `Data` = '" . $upd ['data'] . "' ,`Koha` = '" . $upd['ora'] . "00" . "' ,`Semestri` = '" . $upd['semestri'] . "' WHERE id = '" . $upd['id'] . "'";
        $root->query($sql);

        return TRUE;
    }

    function fetch_afatiprovimit($dre = 0) {
        global $root;
        if ($dre > 0) {

            $array = $root->query($s = "SELECT afati_provimev.id ,afati_provimev.Semestri,Landa.Lendet as EmriLandes,drejtimet.Emri AS EmriDrejtimi, administrata.Emri, administrata.Mbiemri,Data,Koha,afati_provimev.Semestri  "
                    . "  FROM afati_provimev "
                    . " INNER JOIN `Landa` ON Landa.id=afati_provimev.idl"
                    . " INNER JOIN `drejtimet` ON drejtimet.id=afati_provimev.Drejtimi"
                    . " INNER JOIN `administrata` ON administrata.User=afati_provimev.Prof"
                    . " WHERE afati_provimev.Drejtimi = '" . $dre . "' AND Locked = 0 "
                    . " ORDER BY afati_provimev.Drejtimi,afati_provimev.Semestri,Landa.Lendet,administrata.Emri ASC");
        } else {
            $array = $root->query($s = "SELECT  afati_provimev.id,afati_provimev.Semestri ,Landa.Lendet as EmriLandes,drejtimet.Emri AS EmriDrejtimi, administrata.Emri, administrata.Mbiemri,Data,Koha,afati_provimev.Semestri "
                    . " FROM afati_provimev "
                    . " INNER JOIN `Landa` ON Landa.id=afati_provimev.idl"
                    . " INNER JOIN `drejtimet` ON drejtimet.id=afati_provimev.Drejtimi"
                    . " INNER JOIN `administrata` ON administrata.User=afati_provimev.Prof "
                    . " WHERE Locked = 0 "
                    . " ORDER BY afati_provimev.Drejtimi,afati_provimev.Semestri,Landa.Lendet,administrata.Emri ASC");
        }
        return $array;
    }

    function convert_idl($idl) {
        global $root;
        $tt = $root->query("SELECT * FROM `Landa` WHERE id ='" . $idl . "'");

        return $tt;
    }

    function id_afatiprovimit($id) {
        global $root;
        $sql = "SELECT * FROM afati_provimev WHERE id= '" . $id . "'";
        $array = $root->query($sql);

        return $array;
    }

    function allow_noten($info) {
        global $root;

        $sql = "UPDATE notat SET Refuzimi ='2' WHERE Studenti ='" . $info[0][1] . "' AND idl ='" . $info[0][0] . "'";
        echo $sql;
        $root->query($sql);

        return TRUE;
    }

    function edit_student($info) {
        global $root;

        $sql = "UPDATE `personi` SET `User`=" . $info['User'] . ",`Emri`= '" . $info ['Emri'] . "',`Mbiemri`= '" . $info['Mbiemri'] . "',`Emri Prindit`= '" . $info['Emri Prindit'] . "',`Mbiemri Prindit`= '" . $info['Mbiemri Prindit'] . "',`Gjinia`= '" . $info['Gjinia'] . "',`Vendilindjes`= '" . $info['Vendilindjes'] . "',`Datelindja`='" . $info['Datelindja'] . "',`Adressa`='" . $info['Adressa'] . "',`Vendbanimi`='" . $info['Vendbanimi'] . "',`Shteti`='" . $info ['Shteti'] . "',`Kombesia`='" . $info['Kombesia'] . "',`Telefoni`='" . $info ['Telefoni'] . "',`Email`='" . $info['Email'] . "',`Nr Personal`='" . $info['Nr Personal'] . "' ,`Grupi`='" . $info ['Grupi'] . "' WHERE User = " . $info['User'] . "";
        $root->query($sql);
        $sql1 = "UPDATE `student` SET `User`='" . $info ['User'] . "',`Niveli`='" . $info ['Niveli'] . "',`Statusi`='" . $info ['Statusi'] . "',`Drejtimi`='" . $info['Drejtimi'] . "',`Kualifikimi`= '" . $info['Kualifikimi'] . "',`Semestri`= '" . $info['Semestri'] . "',`Zgjedhore`='" . $info['Zgjedhore'] . "',`Viti_regjistrimit`='" . $info['Viti_regjistrimit'] . "',`Locked`='" . $info['Locked'] . "' WHERE 1";
        $root->
                query($sql1);
    }

    function provimet_paraqitura() {
        global $root;
        $provimet = $root->query("SELECT `idl`,`Prof`,`Studenti`,`Paraqitja` FROM notat WHERE Paraqitja = 2 AND Locked = 0");

        return

                $provimet;
    }

    function select_notat($user) {

        global $root;
        $sql = "SELECT idl,Data,Nota,Semestri,Prof FROM notat WHERE Studenti = '" . $user . "'";
        $std = $root->query($sql);
        $list = array();
        foreach ($std as $value) {
            $list[s . $value['Semestri']][] = $value;
        }

        return $list;
    }

    function update_pagesat($user, $pagesa) {
        global $root;
        $sql = "SELECT `S_paguar` FROM `Pagesat` WHERE User = '" . $user . "'";
        $paguara = $root->query($sql);
        $totali = $paguara[0]['S_paguar'] + $pagesa;
        $sql2 = "UPDATE `Pagesat` SET `S_paguar`= '" . $totali . "' WHERE User = '" . $user . "'";
        $root->query($sql2);

        return TRUE;
    }

    function add_lendet($info) {
        global $root;
        $col = array(
            "Lendet",
            "Drejtimi",
            "Semestri",
            "Zgjedhore",
            "ETC");
        $val = array(
            $info['lenda'],
            $info['department'],
            $info ['semestri'],
            $info['zgjedhore'],
            $info['etcs']);
        $root->insert_data("Landa", $col, $val);

        return TRUE;
    }

    function show_drejtimet() {
        global $root;
        $drejtimet = $root->query("SELECT * FROM `drejtimet`");


        return $drejtimet;
    }

    function convert_prof_to_name($user) {
        global $root;
        $adminp = $root->query("SELECT * FROM `administrata` WHERE User = '" . $user . "'");
        return $adminp[0]['Emri'] . " " . $adminp[0][
                'Mbiemri'];
    }

    function convert_drejtimet($dre) {
        global $root;
        $a = $root->query("SELECT * FROM `drejtimet` WHERE id = '" . $dre . "'");

        return $a[0];
    }

    function convert_dep($dp) {
        global $root;
        $a = $root->query("SELECT * FROM `departmentet` WHERE id = '" . $dp . "'");

        return $a[0];
    }

    function show_lendet() {
        global $root;
        $lendet = $root->query("SELECT * FROM `Landa` ORDER BY `Drejtimi`,`Semestri` ASC");
// print_r($lendet);
        foreach ($lendet as $id) {
            $cnt[$id['Drejtimi']][$id['Semestri']][] = $id;

            $cnt[$id['Drejtimi']]['info'] = self::convert_drejtimet($id['Drejtimi']);
            $cnt[$id['Drejtimi']]['info'][] = self::convert_drejtimet($cnt['Drejtimi']['info']['idp']);
        }

        return $cnt;
    }

    function select_professor() {
        global $root;
        $prof = $root->query("SELECT * FROM `administrata` WHERE `Grupi` = 1 ");

        return $prof;
    }

    function edit_department($idp) {
        global $root;
        $dep = $root->query("SELECT * FROM `departmentet` WHERE id = '" . $idp . "'");

        return $dep;
    }

    function update_department($emr, $id) {
        global $root;
        $root->query("UPDATE `departmentet` SET Emri = '" . $emr . "' WHERE id ='" .
                $id . "'");
    }

    function edit_drejtimi($ids) {
        global $root;
        $dre = $root->query("SELECT drejtimet.id AS id, drejtimet.Emri,departmentet.id AS idp,departmentet.Emri AS Emridep FROM `drejtimet`
INNER JOIN departmentet ON departmentet.id = drejtimet.idp
WHERE drejtimet.id ='".$ids."'");

        return $dre[0];
    }

    function update_drejtimi($arr) {
        global $root;
        print_r($arr);
        $root->query("UPDATE `drejtimet` SET `Emri` = '" . $arr ['emridre'] . "', `idp` = '" . $arr['departmenti'] . "' WHERE id = '" . $arr['id'] . "'");

        return TRUE;
    }

//register a department into database
    function add_dep($dep) {
        global $root; // per admintools

        $root->query("INSERT INTO `departmentet` (`Emri`) VALUES ('" . $dep . "') ");
        return TRUE;
    }

//adds drejtimi into dataabase
    function add_drejtim($emri, $idp) {
        global $root;
        $root->query("INSERT INTO `drejtimet` (`Emri`,`idp`) VALUES ('" . $emri . "','" . $idp . "') ");
    }

//adds landa int table landa
    function add_landa($array) {
        global $root;
        $root->query($s = "INSERT INTO `Landa` (`Lendet`,`Drejtimi`,`Semestri`,`Zgjedhore`,`ETC`,`idp`) "
                . "VALUES ('" . $array['emri'] . "','" . $array['drejtimi'] . "','" . $array['semestri'] . "',"
                . "'" . $array['zgjedhore'] . "','" . $array['etc'] . "','" . $array['dep'] . "') ");

        echo $s;
    }

    function update_landa($arr) {
        global $root;

        $s = "UPDATE `Landa` SET `Lendet` = '" . $arr ['emri'] . "',`Drejtimi` = '" . $arr['drejtimi'] . "' ,`Semestri` = '" . $arr['semestri'] . "',`Zgjedhore` = '" . $arr ['zgjedhore'] . "',`ETC` = '" . $arr['etc'] . "',`idp` = '" . $arr ['dep'] . "' WHERE id = '" . $arr['idlendet'] . "'";

        $root->query($s);
        return TRUE;
    }

//afisho departamentet

    function show_department() {
        global $root;
        return $root->query(
                        "SELECT * FROM `departmentet` ");
    }

    function select_lendet($dre) {
        global $root;
        $lendet = $root->query("SELECT * FROM `Landa` WHERE `Drejtimi` = '" . $dre . "'");
        $i = 0;

        foreach ($lendet as $id => $value) {
            $p = self::convert_dep($value['idp']);
            $d = self::convert_drejtimet($value['Drejtimi']);
            $lendet[$i]['Emridepartmentit'] = $p['Emri'];
            $lendet[$i]['Emridrejtimit'] = $d['Emri'];
            $i++;
        }

        return $lendet;
    }

    function edit_lendet($id) {
        global $root;
        $redy = $root->query("SELECT * FROM `Landa` WHERE id = '" . $id . "'");
        return $redy;
    }

//ahisho drejtimet e nje departamenti
    function print_drejtimetEidp($idp) {
        global $root;
        return $root->query("SELECT `id`,`Emri` FROM `drejtimet`  WHERE `idp`='" . $idp . "'");
    }

//afisho  lendet e nje drejtimi  te nje departamenti perkates
    function print_lendet($drejt, $idp) {
        global $root;
        return $root->query("SELECT `id`,`Lendet`,`Drejtimi`,`Semestri`,`Zgjedhore`,`ETC`"
                        . " FROM `Landa` WHERE `idp`='" . $idp . "' AND `Drejtimi`='" . $drejt . "'");
    }

    function regjistrimi_notes($arr) {
        global $root;
        for ($i = 0; $i < count($arr['user']); $i++) {
            $root->query($s = "UPDATE `notat` SET Nota = '" . $arr['nota'][$i] . "', Studenti = '" . $arr['user'][$i] . "' , idl = '" . $arr['lenda'] . "', Data_nota = '" . date("Y-m-d") . "', Locked = '1' WHERE Studenti = '" . $arr['user'][$i] . "' AND idl = '" . $arr['lenda'] . "' AND Paraqitja = 1 ");
            echo $s . "<br>";
        }
    }

    function ref_notat() {
        global $root;
        $refuzimet = $root->query($s = "SELECT `Studenti`,`idl`,`Nota`,`Prof`,`Data` FROM `notat` WHERE Refuzimi = 1 AND Locked = 1");
        for ($i = 0; $i < count($refuzimet); $i++) {
            $temp = self::convert_idl($refuzimet[$i]['idl']);
            $temp1 = self::convert_student_user($refuzimet[$i]['Studenti']);
            $refuzimet[$i]['Lendet'] = $temp[0]['Lendet'];
            $refuzimet[$i]['Emristd'] = $temp1;
            $refuzimet[$i]['Prof'] = self::convert_prof_to_name($refuzimet[$i]['Prof']);
        }
        unset($temp);
        return $refuzimet;
    }

    function lista_provimev($arr) {
        global $root;
        //  echo preg_match("/^[0-9]$/", $arr['drejtimi']);

        for ($i = 0; $i < count($arr); $i++) {
            if ($i == 0 && is_numeric($arr['drejtimi'])) {

                $qu[] = " AND notat.Drejtimi = '" . $arr['drejtimi'] . "'";
            } else if ($i == 1 && is_numeric($arr['landa'])) {
                $qu[] = " AND idl = '" . $arr['landa'] . "'";
            } else if ($i == 2 && is_numeric($arr['semestri'])) {
                $qu[] = " AND notat.Semestri = '" . $arr['semestri'] . "'";
            }
        }

        $qu = implode(" ", $qu);

        $lista = $root->query($s = "SELECT student.User,student.Emri AS Emri_S,student.Mbiemri AS Mbiemri_S,Landa.Lendet,administrata.Emri,administrata.Mbiemri,notat.Data  "
                . "FROM `notat`"
                . "INNER JOIN `Landa` ON Landa.id=notat.idl"
                . " INNER JOIN administrata ON administrata.User=notat.Prof"
                . " INNER JOIN student ON student.User=notat.Studenti"
                . " WHERE notat.Locked = 0 AND Paraqitja = '1' " . $qu . " ORDER BY `idl`,`Emri_S` ASC ");

        return $lista;
    }

    function show_landet_list($arr) {
        global $root, $cache;
        $cache->objcache['User'];
        print_r($cache->objcache);
        for ($i = 0; $i < count($arr); $i++) {
            if ($i == 2 && is_numeric($arr['semestri'])) {
                $q = " AND Semestri = '" . $arr['semestri'] . "'";
            }
        }
        return $root->query("SELECT `id`,`Lendet` AS Emrilandes FROM `Landa` WHERE `Drejtimi` = '" . $arr['drejtimi'] . "'" . $q);
    }

    function print_pdf($title, $html_content, $lp, $fsize) {
        global $root;
        ob_clean();

        $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        $usr = $root->query("SELECT `Emri`,`Mbiemri` FROM administrata WHERE User = '" . $_SESSION['username'] . "'");
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor($usr[0]['Emri'] . " " . $usr[0]['Mbiemri']);
        $pdf->SetTitle($title);
        $pdf->SetSubject($title);
        $pdf->SetKeywords($title);

// set default header data
        $pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE . ' 001', PDF_HEADER_STRING, array(0, 64, 255), array(0, 64, 128));
        $pdf->setFooterData(array(0, 64, 0), array(0, 64, 128));

// set header and footer fonts
        $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
        $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// set auto page breaks
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set image scale factor
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set some language-dependent strings (optional)
        if (@file_exists(dirname(__FILE__) . '/lang/eng.php')) {
            require_once(dirname(__FILE__) . '/lang/eng.php');
            $pdf->setLanguageArray($l);
        }

// ---------------------------------------------------------
// set default font subsetting mode
        $pdf->setFontSubsetting(true);

// Set font
// dejavusans is a UTF-8 Unicode font, if you only need to
// print standard ASCII chars, you can use core fonts like
// helvetica or times to reduce file size.
        $pdf->SetFont('helvetica', '', $fsize, '', true);

// Add a page
// This method has several options, check the source code documentation for more information.

        $pdf->AddPage($lp, 'A4');

// set text shadow effect
        $pdf->setTextShadow(array('enabled' => true, 'depth_w' => 0.2, 'depth_h' => 0.2, 'color' => array(196, 196, 196), 'opacity' => 1, 'blend_mode' => 'Normal'));

// Set some content to print
        $html = <<<EOD
        $html_content
EOD;

// Print text using writeHTMLCell()
        $pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);

// ---------------------------------------------------------
// Close and output PDF document
// This method has several options, check the source code documentation for more information.
        $pdf->Output('example_001.pdf', 'I');
        ob_end_clean();
//============================================================+
// END OF FILE
//============================================================+
    }
    
    
}
?>
