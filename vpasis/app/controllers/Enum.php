<?php

class Enum extends Controller {
    /*
     * ________________________________ | Autori: Alban Mulaki | | E-Mail: alban.mulaki@gmail.com | ________________________________
     */
    /*
     * Grupet per access
     */

    const student = 1;
    const puntor = 2;
    const prof = 3;
    const referent = 4;
    const dekani = 5;
    const drejtori = 6;
    const admin = 7;
    const asistent = 8;
    const normal = 0;
    const high = 1;
    const critical = 2;
    const seen = 1;
    const noseen = 0;
    const thread = 1;
    const nothread = 2;
    const locked = 1;
    const nolocked = 0;
    const closed = 0;
    /*
     * Statusi studenteve
     */
    const irregullt = 0;
    const joirregullt = 1;
    /*
     * Pagesat
     */
    const kontrat = 0;
    const jokontrat = 1;
    /*
     * Provimet
     */
    const notalbum = 0;
    const album = 1;
    const paraqitur = 1;
    const paraqiturprezent = 2;
    const refuzuar = 1;
    const parefuzuar = 0;
    const notdeleted = 0;
    const deleted = 1;

    /*
     * gradata shkencore
     */
    const master = 4;
    const phd = 1;
    const dr = 2;
    const akademik = 3;
    const phdcan = 5;

    public static function convertrefuzimin($ref) {
        if ($ref == self::parefuzuar) {
            return Lang::get('general.yes');
        } else if ($ref == self::refuzuar) {
            return Lang::get('general.no');
        }
    }

    /*
     * Gjinia
     */

    const mashkull = 0;
    const femer = 1;
    const no = 0;
    const yes = 1;
    const pending = 2;
    const hene = 0;
    const marte = 1;
    const merkure = 2;
    const enjete = 3;
    const premte = 4;
    const shtune = 5;
    const diel = 6;
    const grupiA = 0;
    const grupiB = 1;
    const grupiC = 2;
    const transfer = 1;
    const jotransfer = 0;
    const bachelor = 1;
    const absolvent = 4;
    const active = 1;
    const passive = 2;
    const zgjedhore = 1;
    const jozgjedhore = 0;
    const notlocksem = 0;
    const locksem = 1;
    const confirmed = 1;
    const notconfirmed = 0;


    # Check Responses
    const successful = 1;
    const failed = 2;



    /*
     * Llojet e pagesave
     */
    const pagessemestri = 1;
    const pagestjeter = 2;

    public static function getLlojetPagesave() {
        return array(-1 => Lang::get('general.select_feetype'),
            self::pagessemestri => Lang::get('general.fee_semester'),
            self::pagestjeter => Lang::get('general.other')
        );
    }

    public static function convertLlojetPagesave($acc) {

        switch ($acc) {
            case self::pagessemestri :
                return Lang::get('general.fee_semester');
                break;
            case self::pagestjeter :
                return Lang::get('general.other');
                break;
        }
    }

    public static function getGjinia() {
        return array(-1 => Lang::get('general.gender'),
            self::mashkull => Lang::get('general.male'),
            self::femer => Lang::get('general.female')
        );
    }

    public static function convertGjinia($acc) {
        switch ($acc) {
            case self::mashkull :
                return Lang::get('general.male');
                break;
            case self::femer :
                return Lang::get('general.female');
                break;
        }
    }

    public static function convertDetyra($acc) {
        switch ($acc) {
            case self::prof :
                return Lang::get('general.lecturer');
                break;
            case self::asistent :
                return Lang::get('general.assistent');
                break;
        }
    }

    /*
     * Return array for combobox
     */

    public static function getActive() {
        return array(Enum::active => Lang::get('general.active'),
            Enum::passive => Lang::get('general.passive'));
    }

    /*
     * Return array for combobox
     */

    public static function getZgjedhore() {
        return array(Enum::zgjedhore => Lang::get('general.yes'),
            Enum::jozgjedhore => Lang::get('general.no'));
    }

    /*
     * Return array for combobox
     */

    public static function getGrp() {
        return array(-1 => Lang::get('general.position_office_choose'),
            self::prof => Lang::get('general.lecturer'),
            self::asistent => Lang::get('general.assistent'),
            self::referent => Lang::get('general.referent_e'),
            self::asistent => Lang::get('general.assistent'),
            self::admin => Lang::get('general.admin')
        );
    }

    const v2011 = "2011-2012";
    const v2012 = "2012-2013";
    const v2013 = "2013-2014";
    const v2014 = "2014-2015";
    const v2015 = "2015-2016";

    public static function getVitiAka() {
        return array(-1 => Lang::get('general.choose_academic_year'),
            self::v2011 => self::v2011,
            self::v2012 => self::v2012,
            self::v2013 => self::v2013,
            self::v2014 => self::v2014,
            self::v2015 => self::v2015,
        );
    }

    /*
     * Return array for combobox
     */

    public static function getStatus() {
        return array(self::irregullt => Lang::get('general.regular'),
            self::joirregullt => Lang::get('general.not_regular')
        );
    }

    /*
     * Return array for combobox
     */

    public static function getLevel() {
        return array(self::bachelor => Lang::get('general.bachelor'),
            self::master => Lang::get('general.master')
        );
    }

    /*
     * Return array for combobox
     */

    public static function getGrade() {
        return array(
            self::master => Lang::get('general.msc'),
            self::phdcan => Lang::get('general.phdcandidat'),
            self::phd => Lang::get('general.phd'),
            self::dr => Lang::get('general.dr'),
            self::akademik => Lang::get('general.academic'));
    }

    /*
     * Return array for combobox
     */

    public static function getSemester() {
        return array(
            -1 => Lang::get('general.choose_semester'),
            1 => 1,
            2 => 2,
            3 => 3,
            4 => 4,
            5 => 5,
            6 => 6);
    }

    public static function convertLevel($acc) {
        switch ($acc) {
            case self::bachelor :
                return Lang::get('general.bachelor');
                break;
            case self::master :
                return Lang::get('general.master');
                break;
        }
    }

    public static function convertgrade($acc) {

        switch ($acc) {
            case self::master :
                return Lang::get('general.msc');
                break;
            case self::phdcan :
                return Lang::get('general.phdcandidat');
                break;

            case self::dr :
                return Lang::get('general.dr');
                break;

            case self::akademik :
                return Lang::get('general.akademik');
                break;
        }
    }

    public static function convertTransfer($acc) {

        switch ($acc) {
            case self::transfer :
                return Lang::get('general.yes');
                break;
            case self::jotransfer:
                return Lang::get('general.no');
                break;
        }
    }

    public static function convertstatusi($statusi) {

        switch ($statusi) {
            case self::irregullt :
                return Lang::get('general.regular');
                break;
            case self::irregullt :
                return Lang::get('general.joirregullt');
                break;
        }
    }

    public static function convertdrejtimi($id) {
        $drejtimi = Drejtimet::where('idDrejtimet', '=', $id)->get();
        return $drejtimi[0]['Emri'];
    }

    public static function convertaccess($acc) {

        switch ($acc) {
            case self::student :
                return Lang::get('general.student');
                break;

            case self::puntor :
                return Lang::get('general.workers');
                break;

            case self::prof :
                return Lang::get('general.professor');
                break;

            case self::referent :
                return Lang::get('general.referent');
                break;

            case self::dekani :
                return Lang::get('general.dekani');
                break;

            case self::drejtori :
                return Lang::get('general.director');
                break;
            case self::admin :
                return Lang::get('general.admin_it');
                break;
        }
    }

    public static function convertday($day) {
        switch ($day) {
            case self::hene :
                return Lang::get('general.monday');
                break;

            case self::marte :
                return Lang::get('general.tuesday');
                break;

            case self::merkure :
                return Lang::get('general.wednesday');
                break;

            case self::enjete :
                return Lang::get('general.thursday');
                break;

            case self::premte :
                return Lang::get('general.friday');
                break;

            case self::shtune :
                return Lang::get('general.saturday');
                break;
        }
    }

}
