<?php

namespace Supplycart\Xero\Data\Attachment;

use Spatie\DataTransferObject\DataTransferObject;

class Attachment extends DataTransferObject
{
    public $AttachmentID;

    public $FileName;

    public $Url;

    public $MimeType;

    public $ContentLength;

    public $IncludeOnline;

    public $ValidationErrors;

    public $StatusAttributeString;
}
