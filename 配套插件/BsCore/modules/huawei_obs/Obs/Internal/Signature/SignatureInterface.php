<?php

namespace Obs\Internal\Signature;

use Obs\Internal\Common\Model;

interface SignatureInterface
{
	function doAuth(array &$requestConfig, array &$params, Model $model);
}