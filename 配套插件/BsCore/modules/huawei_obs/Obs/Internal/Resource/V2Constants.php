<?php
namespace Obs\Internal\Resource;

class V2Constants extends Constants {
    const FLAG = 'AWS';
    const METADATA_PREFIX = 'x-amz-meta-';
    const HEADER_PREFIX = 'x-amz-';
    const ALTERNATIVE_DATE_HEADER = 'x-amz-date';
    const SECURITY_TOKEN_HEAD = 'x-amz-security-token';
    const TEMPURL_AK_HEAD = 'AWSAccessKeyId';
    
    const GROUP_ALL_USERS_PREFIX = 'http://acs.amazonaws.com/groups/global/';
    const GROUP_AUTHENTICATED_USERS_PREFIX = 'http://acs.amazonaws.com/groups/global/';
    const GROUP_LOG_DELIVERY_PREFIX = 'http://acs.amazonaws.com/groups/s3/';
    
    const COMMON_HEADERS = [
        'content-length' => 'ContentLength',
        'date' => 'Date',
        'x-amz-request-id' => 'RequestId',
        'x-amz-id-2' => 'Id2',
        'x-reserved' => 'Reserved'
    ];
}
