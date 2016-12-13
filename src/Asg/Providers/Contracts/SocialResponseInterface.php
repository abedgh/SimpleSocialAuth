<?php
/**
 * Created by PhpStorm.
 * User: abed
 * Date: 12/12/16
 * Time: 6:22 PM
 */

namespace Asg\Providers\Contracts;

interface SocialResponseInterface {

    /**
     * @return mixed|null;
     * */
    public function getId();
    /* ---------------------------------------------- */
    /**
     * @return string|null
     * */
    public function getEmail();

    /**
     * @return string
     * */
    public function getName();

    /**
     * @return string
     * */
    public function getFirstName();

    /**
     * @return string
     * */
    public function getLastName();

    /**
     * @param string $name;
     * @return mixed;
     * */
    public function getField($name);

    /**
     * @return bool;
     * */
    public function isVerified();

    /**
     * @return mixed;
     * */
    public function payload();

}