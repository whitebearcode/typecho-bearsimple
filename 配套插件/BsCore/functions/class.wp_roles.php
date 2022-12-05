<?php

if (!class_exists('WP_Roles')) {

    class WP_Roles
    {
        /**
         * @var array[]
         */
        /**
         * List of roles and capabilities.
         *
         * @since 2.0.0
         * @var array[]
         */
        public $roles;

        public function __construct($site_id = null)
        {

            $this->roles = [
                'administrator' => [
                    'name' => '管理员'
                ],
                'editor' => [
                    'name' => '编辑'
                ],
                'contributor' => [
                    'name' => '贡献者'
                ],
                'subscriber' => [
                    'name' => '关注者'
                ],
                'visitor' => [
                    'name' => '访问者'
                ],
            ];

        }

    }
}
