<?php
namespace Obs\Internal\Resource;

class OBSConstants extends Constants {
    const FLAG = 'OBS';
    const METADATA_PREFIX = 'x-obs-meta-';
    const HEADER_PREFIX = 'x-obs-';
    const ALTERNATIVE_DATE_HEADER = 'x-obs-date';
    const SECURITY_TOKEN_HEAD = 'x-obs-security-token';
    const TEMPURL_AK_HEAD = 'AccessKeyId';
    
    const COMMON_HEADERS = [
        'content-length' => 'ContentLength',
        'date' => 'Date',
        'x-obs-request-id' => 'RequestId',
        'x-obs-id-2' => 'Id2',
        'x-reserved' => 'Reserved'
    ];
}
