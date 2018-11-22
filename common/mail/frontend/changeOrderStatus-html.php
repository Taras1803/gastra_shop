<?php

use yii\helpers\Html;

/* @var $this yii\web\View */

$site_name = Yii::$app->params['site_name'];
$site_url = Yii::$app->params['siteUrl'];
$site_logo = $site_url . Yii::$app->params['siteLogo'];
?>

<style>
    /****** responsive ********/
    @media only screen and (max-width: 300px) {
        body {
            width: 218px !important;
            margin: auto !important;
        }

        .table {
            width: 195px !important;
            margin: auto !important;
        }

        .logo, .titleblock, .linkbelow, .box, .footer, .space_footer {
            width: auto !important;
            display: block !important;
        }

        span.title {
            font-size: 20px !important;
            line-height: 23px !important
        }

        span.subtitle {
            font-size: 14px !important;
            line-height: 18px !important;
            padding-top: 10px !important;
            display: block !important;
        }

        td.box p {
            font-size: 12px !important;
            font-weight: bold !important;
        }

        .table-recap table, .table-recap thead, .table-recap tbody, .table-recap th, .table-recap td, .table-recap tr {
            display: block !important;
        }

        .table-recap {
            width: 200px !important;
        }

        .table-recap tr td, .conf_body td {
            text-align: center !important;
        }

        .address {
            display: block !important;
            margin-bottom: 10px !important;
        }

        .space_address {
            display: none !important;
        }
    }

    @media only screen and (min-width: 301px) and (max-width: 500px) {
        body {
            width: 308px !important;
            margin: auto !important;
        }

        .table {
            width: 285px !important;
            margin: auto !important;
        }

        .logo, .titleblock, .linkbelow, .box, .footer, .space_footer {
            width: auto !important;
            display: block !important;
        }

        .table-recap table, .table-recap thead, .table-recap tbody, .table-recap th, .table-recap td, .table-recap tr {
            display: block !important;
        }

        .table-recap {
            width: 293px !important;
        }

        .table-recap tr td, .conf_body td {
            text-align: center !important;
        }

    }

    @media only screen and (min-width: 501px) and (max-width: 768px) {
        body {
            width: 478px !important;
            margin: auto !important;
        }

        .table {
            width: 450px !important;
            margin: auto !important;
        }

        .logo, .titleblock, .linkbelow, .box, .footer, .space_footer {
            width: auto !important;
            display: block !important;
        }
    }

    /* Mobile */

    @media only screen and (max-device-width: 480px) {
        body {
            width: 308px !important;
            margin: auto !important;
        }

        .table {
            width: 285px;
            margin: auto !important;
        }

        .logo, .titleblock, .linkbelow, .box, .footer, .space_footer {
            width: auto !important;
            display: block !important;
        }

        .table-recap {
            width: 285px !important;
        }

        .table-recap tr td, .conf_body td {
            text-align: center !important;
        }

        .address {
            display: block !important;
            margin-bottom: 10px !important;
        }

        .space_address {
            display: none !important;
        }
    }
</style>

<body style="background-color:#fff;width:650px;font-family:Open-sans, sans-serif;color:#555454;font-size:13px;line-height:18px;margin:auto">
<?php $this->beginBody() ?>
<table class="table table-mail"
       style="width:100%;margin-top:10px;-moz-box-shadow:0 0 5px #afafaf;-webkit-box-shadow:0 0 5px #afafaf;-o-box-shadow:0 0 5px #afafaf;box-shadow:0 0 5px #afafaf;filter:progid:DXImageTransform.Microsoft.Shadow(color=#afafaf,Direction=134,Strength=5)">
    <tr>
        <td class="space" style="width:20px;border:none;padding:7px 0">&nbsp;</td>
        <td align="center" style="border:none;padding:7px 0">
            <table class="table" style="width:100%;background-color:#fff">
                <tr>
                    <td align="center" class="logo" style="border-bottom:4px solid #333333;padding:7px 0">
                        <a title="<?= $site_name ?>" href="<?= $site_url ?>" style="color:#337ff1">
                            <img src="<?= $site_logo ?>" style="width: 430px;" alt="<?= $site_name ?>"/>
                        </a>
                    </td>
                </tr>
                <tr>
                    <td align="center" class="titleblock" style="border:none;padding:7px 0">
                        <span class="title"
                              style="font-weight:500;font-size:24px;text-transform:uppercase;line-height:33px"><?= Yii::t('mail', 'change_order_status') ?></span>
                    </td>
                </tr>
                <tr>
                    <td class="space_footer" style="padding:0!important;border:none">&nbsp;</td>
                </tr>
                <tr>
                    <td class="box" colspan="3"
                        style="background-color:#fbfbfb;border:1px solid #d6d4d4!important;padding:10px!important">
                        <p style="margin:3px 0 7px;text-transform:uppercase;font-weight:500;font-size:18px;border-bottom:1px solid #d6d4d4!important;padding-bottom:10px">
                            <?= Yii::t('mail', 'order') ?> №<?= $data['orderId'] ?>
                        </p>
                        <span style="color:#777">
                            <?= Yii::t('mail', 'order_status') ?>: <?= $data['status'] ?>
                        </span>
                    </td>
                </tr>
                <tr>
                    <td class="linkbelow" style="padding:7px 0">
                        <font size="2" face="Open-sans, sans-serif" color="#555454">
			                <span style="color: #D52020; text-align: center;">
				                <?= Yii::t('mail', 'this_message_send') ?>
                            </span>
                        </font>
                    </td>
                </tr>
                <tr>
                    <td class="space_footer" style="padding:0!important;border:none">&nbsp;</td>
                </tr>
                <tr>
                    <td class="space_footer" style="padding:0!important;border:none">&nbsp;</td>
                </tr>
                <tr>
                    <td class="footer" style="border-top:4px solid #333333;padding:7px 0">

                    </td>
                </tr>
            </table>
        </td>
        <td class="space" style="width:20px;border:none;padding:7px 0">&nbsp;</td>
    </tr>
</table>
<?php $this->endBody() ?>
</body>
