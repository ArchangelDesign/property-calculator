<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitfa75c14429adc801f1a2514735dc9229
{
    public static $files = array (
        '79f66bc0a1900f77abe4a9a299057a0a' => __DIR__ . '/..' . '/starkbank/ecdsa/src/ellipticcurve.php',
    );

    public static $prefixLengthsPsr4 = array (
        'S' => 
        array (
            'SendGrid\\Stats\\' => 15,
            'SendGrid\\Mail\\' => 14,
            'SendGrid\\Helper\\' => 16,
            'SendGrid\\EventWebhook\\' => 22,
            'SendGrid\\Contacts\\' => 18,
            'SendGrid\\' => 9,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'SendGrid\\Stats\\' => 
        array (
            0 => __DIR__ . '/..' . '/sendgrid/sendgrid/lib/stats',
        ),
        'SendGrid\\Mail\\' => 
        array (
            0 => __DIR__ . '/..' . '/sendgrid/sendgrid/lib/mail',
        ),
        'SendGrid\\Helper\\' => 
        array (
            0 => __DIR__ . '/..' . '/sendgrid/sendgrid/lib/helper',
        ),
        'SendGrid\\EventWebhook\\' => 
        array (
            0 => __DIR__ . '/..' . '/sendgrid/sendgrid/lib/eventwebhook',
        ),
        'SendGrid\\Contacts\\' => 
        array (
            0 => __DIR__ . '/..' . '/sendgrid/sendgrid/lib/contacts',
        ),
        'SendGrid\\' => 
        array (
            0 => __DIR__ . '/..' . '/sendgrid/php-http-client/lib',
        ),
    );

    public static $classMap = array (
        'BaseSendGridClientInterface' => __DIR__ . '/..' . '/sendgrid/sendgrid/lib/BaseSendGridClientInterface.php',
        'SendGrid' => __DIR__ . '/..' . '/sendgrid/sendgrid/lib/SendGrid.php',
        'SendGrid\\Client' => __DIR__ . '/..' . '/sendgrid/php-http-client/lib/Client.php',
        'SendGrid\\Contacts\\Recipient' => __DIR__ . '/..' . '/sendgrid/sendgrid/lib/contacts/Recipient.php',
        'SendGrid\\Contacts\\RecipientForm' => __DIR__ . '/..' . '/sendgrid/sendgrid/lib/contacts/RecipientForm.php',
        'SendGrid\\EventWebhook\\EventWebhook' => __DIR__ . '/..' . '/sendgrid/sendgrid/lib/eventwebhook/EventWebhook.php',
        'SendGrid\\EventWebhook\\EventWebhookHeader' => __DIR__ . '/..' . '/sendgrid/sendgrid/lib/eventwebhook/EventWebhookHeader.php',
        'SendGrid\\Exception\\InvalidRequest' => __DIR__ . '/..' . '/sendgrid/php-http-client/lib/Exception/InvalidRequest.php',
        'SendGrid\\Helper\\Assert' => __DIR__ . '/..' . '/sendgrid/sendgrid/lib/helper/Assert.php',
        'SendGrid\\Mail\\Asm' => __DIR__ . '/..' . '/sendgrid/sendgrid/lib/mail/Asm.php',
        'SendGrid\\Mail\\Attachment' => __DIR__ . '/..' . '/sendgrid/sendgrid/lib/mail/Attachment.php',
        'SendGrid\\Mail\\BatchId' => __DIR__ . '/..' . '/sendgrid/sendgrid/lib/mail/BatchId.php',
        'SendGrid\\Mail\\Bcc' => __DIR__ . '/..' . '/sendgrid/sendgrid/lib/mail/Bcc.php',
        'SendGrid\\Mail\\BccSettings' => __DIR__ . '/..' . '/sendgrid/sendgrid/lib/mail/BccSettings.php',
        'SendGrid\\Mail\\BypassListManagement' => __DIR__ . '/..' . '/sendgrid/sendgrid/lib/mail/BypassListManagement.php',
        'SendGrid\\Mail\\Category' => __DIR__ . '/..' . '/sendgrid/sendgrid/lib/mail/Category.php',
        'SendGrid\\Mail\\Cc' => __DIR__ . '/..' . '/sendgrid/sendgrid/lib/mail/Cc.php',
        'SendGrid\\Mail\\ClickTracking' => __DIR__ . '/..' . '/sendgrid/sendgrid/lib/mail/ClickTracking.php',
        'SendGrid\\Mail\\Content' => __DIR__ . '/..' . '/sendgrid/sendgrid/lib/mail/Content.php',
        'SendGrid\\Mail\\CustomArg' => __DIR__ . '/..' . '/sendgrid/sendgrid/lib/mail/CustomArg.php',
        'SendGrid\\Mail\\EmailAddress' => __DIR__ . '/..' . '/sendgrid/sendgrid/lib/mail/EmailAddress.php',
        'SendGrid\\Mail\\Footer' => __DIR__ . '/..' . '/sendgrid/sendgrid/lib/mail/Footer.php',
        'SendGrid\\Mail\\From' => __DIR__ . '/..' . '/sendgrid/sendgrid/lib/mail/From.php',
        'SendGrid\\Mail\\Ganalytics' => __DIR__ . '/..' . '/sendgrid/sendgrid/lib/mail/Ganalytics.php',
        'SendGrid\\Mail\\GroupId' => __DIR__ . '/..' . '/sendgrid/sendgrid/lib/mail/GroupId.php',
        'SendGrid\\Mail\\GroupsToDisplay' => __DIR__ . '/..' . '/sendgrid/sendgrid/lib/mail/GroupsToDisplay.php',
        'SendGrid\\Mail\\Header' => __DIR__ . '/..' . '/sendgrid/sendgrid/lib/mail/Header.php',
        'SendGrid\\Mail\\HtmlContent' => __DIR__ . '/..' . '/sendgrid/sendgrid/lib/mail/HtmlContent.php',
        'SendGrid\\Mail\\IpPoolName' => __DIR__ . '/..' . '/sendgrid/sendgrid/lib/mail/IpPoolName.php',
        'SendGrid\\Mail\\Mail' => __DIR__ . '/..' . '/sendgrid/sendgrid/lib/mail/Mail.php',
        'SendGrid\\Mail\\MailSettings' => __DIR__ . '/..' . '/sendgrid/sendgrid/lib/mail/MailSettings.php',
        'SendGrid\\Mail\\MimeType' => __DIR__ . '/..' . '/sendgrid/sendgrid/lib/mail/MimeType.php',
        'SendGrid\\Mail\\OpenTracking' => __DIR__ . '/..' . '/sendgrid/sendgrid/lib/mail/OpenTracking.php',
        'SendGrid\\Mail\\Personalization' => __DIR__ . '/..' . '/sendgrid/sendgrid/lib/mail/Personalization.php',
        'SendGrid\\Mail\\PlainTextContent' => __DIR__ . '/..' . '/sendgrid/sendgrid/lib/mail/PlainTextContent.php',
        'SendGrid\\Mail\\ReplyTo' => __DIR__ . '/..' . '/sendgrid/sendgrid/lib/mail/ReplyTo.php',
        'SendGrid\\Mail\\SandBoxMode' => __DIR__ . '/..' . '/sendgrid/sendgrid/lib/mail/SandBoxMode.php',
        'SendGrid\\Mail\\Section' => __DIR__ . '/..' . '/sendgrid/sendgrid/lib/mail/Section.php',
        'SendGrid\\Mail\\SendAt' => __DIR__ . '/..' . '/sendgrid/sendgrid/lib/mail/SendAt.php',
        'SendGrid\\Mail\\SpamCheck' => __DIR__ . '/..' . '/sendgrid/sendgrid/lib/mail/SpamCheck.php',
        'SendGrid\\Mail\\Subject' => __DIR__ . '/..' . '/sendgrid/sendgrid/lib/mail/Subject.php',
        'SendGrid\\Mail\\SubscriptionTracking' => __DIR__ . '/..' . '/sendgrid/sendgrid/lib/mail/SubscriptionTracking.php',
        'SendGrid\\Mail\\Substitution' => __DIR__ . '/..' . '/sendgrid/sendgrid/lib/mail/Substitution.php',
        'SendGrid\\Mail\\TemplateId' => __DIR__ . '/..' . '/sendgrid/sendgrid/lib/mail/TemplateId.php',
        'SendGrid\\Mail\\To' => __DIR__ . '/..' . '/sendgrid/sendgrid/lib/mail/To.php',
        'SendGrid\\Mail\\TrackingSettings' => __DIR__ . '/..' . '/sendgrid/sendgrid/lib/mail/TrackingSettings.php',
        'SendGrid\\Mail\\TypeException' => __DIR__ . '/..' . '/sendgrid/sendgrid/lib/mail/TypeException.php',
        'SendGrid\\Response' => __DIR__ . '/..' . '/sendgrid/php-http-client/lib/Response.php',
        'SendGrid\\Stats\\Stats' => __DIR__ . '/..' . '/sendgrid/sendgrid/lib/stats/Stats.php',
        'TwilioEmail' => __DIR__ . '/..' . '/sendgrid/sendgrid/lib/TwilioEmail.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitfa75c14429adc801f1a2514735dc9229::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitfa75c14429adc801f1a2514735dc9229::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInitfa75c14429adc801f1a2514735dc9229::$classMap;

        }, null, ClassLoader::class);
    }
}
