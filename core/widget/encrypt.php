<?php
header("HTTP/1.1 200 OK");
header("Access-Control-Allow-Origin: *");
date_default_timezone_set('PRC');

if (@$_POST['action'] == 'open_lock') {
						if (!empty($_POST['password'])) {
							$password = $_POST['password'];
							$md5 = $_POST['encryptpassword'];
							$type = $_POST['type'];
							$options = bsOptions::getInstance()::get_option('bearsimple');
							if (md5Encode($password) == $md5) {
								$result = array('code' => '1');
								if ($type == 'category') {
									$category = $_POST['category'];
									Typecho_Cookie::set('category_' . $category, md5Encode($password));
								}
							} else {
								$result = array('code' => '-1');
							}
						} else {
							$result = array('code' => '-2');
						}
						exit(json_encode($result,JSON_UNESCAPED_UNICODE));
					}