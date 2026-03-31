{{--
    File: verify-email.blade.php
    Description: Branded email verification template with region-specific styling
    Copyright: 2026 Cloudmanic Labs, LLC
    Date: 2026-01-22
--}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify Your Email</title>
    <!--[if mso]>
    <noscript>
        <xml>
            <o:OfficeDocumentSettings>
                <o:PixelsPerInch>96</o:PixelsPerInch>
            </o:OfficeDocumentSettings>
        </xml>
    </noscript>
    <![endif]-->
    <style>
        /* Reset styles */
        body, table, td, p, a, li, blockquote {
            -webkit-text-size-adjust: 100%;
            -ms-text-size-adjust: 100%;
        }
        table, td {
            mso-table-lspace: 0pt;
            mso-table-rspace: 0pt;
        }
        img {
            -ms-interpolation-mode: bicubic;
            border: 0;
            height: auto;
            line-height: 100%;
            outline: none;
            text-decoration: none;
        }
        body {
            margin: 0 !important;
            padding: 0 !important;
            width: 100% !important;
        }
        a {
            color: #059669;
        }
        @media screen and (max-width: 600px) {
            .email-container {
                width: 100% !important;
            }
            .mobile-padding {
                padding: 20px !important;
            }
        }
    </style>
</head>
<body style="margin: 0; padding: 0; background-color: #f8fafc; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;">
    <!-- Preview text -->
    <div style="display: none; max-height: 0px; overflow: hidden;">
        Verify your {{ $city['brand'] }} email address - this link expires in 60 minutes
    </div>

    <!-- Email Container -->
    <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%" style="background-color: #f8fafc;">
        <tr>
            <td style="padding: 40px 20px;">
                <!-- Main Content Card -->
                <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="600" class="email-container" style="margin: 0 auto; background-color: #ffffff; border-radius: 16px; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);">
                    <!-- Header -->
                    <tr>
                        <td style="padding: 40px 40px 30px 40px; text-align: center; border-bottom: 1px solid #e2e8f0;" class="mobile-padding">
                            <!-- Logo -->
                            <table role="presentation" cellspacing="0" cellpadding="0" border="0" style="margin: 0 auto;">
                                <tr>
                                    <td style="background-color: #059669; width: 48px; height: 48px; border-radius: 12px; text-align: center; vertical-align: middle;">
                                        <span style="color: #ffffff; font-size: 18px; font-weight: bold;">{{ substr($city['name'], 0, 1) }}L</span>
                                    </td>
                                    <td style="padding-left: 12px;">
                                        <span style="font-size: 20px; font-weight: bold; color: #0f172a;">{{ $city['name'] }}</span>
                                        <span style="font-size: 20px; font-weight: bold; color: #059669; font-style: italic;"> Laundry</span>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <!-- Body Content -->
                    <tr>
                        <td style="padding: 40px;" class="mobile-padding">
                            <!-- Icon -->
                            <table role="presentation" cellspacing="0" cellpadding="0" border="0" style="margin: 0 auto 24px auto;">
                                <tr>
                                    <td style="background-color: #ecfdf5; width: 64px; height: 64px; border-radius: 50%; text-align: center; vertical-align: middle;">
                                        <!-- Email Checkmark Icon -->
                                        <img src="https://cdn-icons-png.flaticon.com/512/3596/3596091.png" alt="Verify Email" width="32" height="32" style="display: inline-block;" />
                                    </td>
                                </tr>
                            </table>

                            <!-- Heading -->
                            <h1 style="margin: 0 0 16px 0; font-size: 24px; font-weight: bold; color: #0f172a; text-align: center;">
                                Verify Your Email Address
                            </h1>

                            <!-- Greeting -->
                            <p style="margin: 0 0 24px 0; font-size: 16px; line-height: 24px; color: #475569; text-align: center;">
                                Hi{{ isset($user) && $user->first_name ? ' ' . $user->first_name : '' }},
                            </p>

                            <!-- Message -->
                            <p style="margin: 0 0 24px 0; font-size: 16px; line-height: 24px; color: #475569;">
                                Thank you for creating your {{ $city['brand'] }} account! Please click the button below to verify your email address and get started with your laundry service.
                            </p>

                            <!-- CTA Button -->
                            <table role="presentation" cellspacing="0" cellpadding="0" border="0" style="margin: 0 auto 24px auto;">
                                <tr>
                                    <td style="border-radius: 12px; background-color: #059669;">
                                        <a href="{{ $url }}" target="_blank" style="display: inline-block; padding: 16px 32px; font-size: 16px; font-weight: bold; color: #ffffff; text-decoration: none; border-radius: 12px;">
                                            Verify Email Address
                                        </a>
                                    </td>
                                </tr>
                            </table>

                            <!-- Expiration Notice -->
                            <div style="background-color: #fef3c7; border: 1px solid #fcd34d; border-radius: 12px; padding: 16px; margin-bottom: 24px;">
                                <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%">
                                    <tr>
                                        <td style="width: 24px; vertical-align: top; padding-right: 12px;">
                                            <!-- Clock Icon -->
                                            <span style="font-size: 20px;">&#9200;</span>
                                        </td>
                                        <td>
                                            <p style="margin: 0; font-size: 14px; line-height: 20px; color: #92400e;">
                                                <strong>This link expires in 60 minutes.</strong><br>
                                                After that, you'll need to request a new verification email.
                                            </p>
                                        </td>
                                    </tr>
                                </table>
                            </div>

                            <!-- Alternative Link -->
                            <p style="margin: 0 0 16px 0; font-size: 14px; line-height: 20px; color: #64748b;">
                                If the button doesn't work, copy and paste this link into your browser:
                            </p>
                            <p style="margin: 0 0 24px 0; font-size: 12px; line-height: 18px; color: #059669; word-break: break-all;">
                                <a href="{{ $url }}" style="color: #059669;">{{ $url }}</a>
                            </p>

                            <!-- Security Notice -->
                            <div style="background-color: #f1f5f9; border-radius: 12px; padding: 16px;">
                                <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%">
                                    <tr>
                                        <td style="width: 24px; vertical-align: top; padding-right: 12px;">
                                            <!-- Shield Icon -->
                                            <span style="font-size: 20px;">&#128274;</span>
                                        </td>
                                        <td>
                                            <p style="margin: 0; font-size: 14px; line-height: 20px; color: #475569;">
                                                <strong>Didn't create this account?</strong><br>
                                                If you didn't sign up for {{ $city['brand'] }}, you can safely ignore this email. No account will be created without verification.
                                            </p>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td style="padding: 30px 40px; background-color: #f8fafc; border-top: 1px solid #e2e8f0; border-radius: 0 0 16px 16px;" class="mobile-padding">
                            <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%">
                                <tr>
                                    <td style="text-align: center;">
                                        <p style="margin: 0 0 8px 0; font-size: 14px; line-height: 20px; color: #64748b;">
                                            Questions? Contact us at
                                            <a href="mailto:{{ $city['contact']['support_email'] }}" style="color: #059669; text-decoration: none;">{{ $city['contact']['support_email'] }}</a>
                                        </p>
                                        <p style="margin: 0 0 16px 0; font-size: 14px; line-height: 20px; color: #64748b;">
                                            or call <a href="tel:{{ $city['contact']['phone'] }}" style="color: #059669; text-decoration: none;">{{ $city['contact']['phone'] }}</a>
                                        </p>
                                        <p style="margin: 0; font-size: 12px; line-height: 18px; color: #94a3b8;">
                                            {{ $city['brand'] }}<br>
                                            {{ $city['contact']['address_full'] }}
                                        </p>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>

                <!-- Legal Footer -->
                <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="600" class="email-container" style="margin: 20px auto 0 auto;">
                    <tr>
                        <td style="text-align: center; padding: 0 20px;">
                            <p style="margin: 0; font-size: 11px; line-height: 16px; color: #94a3b8;">
                                This email was sent to you because an account was created with this email address at {{ $city['brand'] }}.
                                This is a transactional email and is not promotional in nature.
                            </p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
