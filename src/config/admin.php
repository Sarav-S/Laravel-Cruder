<?php


return [
    /**
     * This is the admin url. Changing url will
     * reflect the entire system
     */
    'url' => 'admin',

    /**
     * This is for crud automation. For example on admin
     * panel, will performing crud operation we will
     * take segment like baseurl.com/admin/users/3. Here
     * 3 is segment three. Whenever you change url segments
     * above this should be modified.
     */
    'segment' => 3,

    /**
     * This url is for module creator. Keeping it null will disable
     * module creator module.
     */
    'mc_url' => 'mc',

    /**
     * Setting it to true, enables the mc creation modules routes.
     * By default, its enabled.
     */
    'mc_status' => true,
];
