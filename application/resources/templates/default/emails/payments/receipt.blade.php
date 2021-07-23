<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional" "https://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="https://www.w3.org/1999/xhtml" lang="en">
  <head>
    <title>{{ trans('email.receipt_title', ['company' => $settings['companyName'], 'number' => $payment->id]) }}</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width" />
    <meta name="robots" content="noindex, nofollow" />
    <meta name="googlebot" content="noindex, nofollow, noarchive" />

    <style type="text/css">
a {
  text-decoration: none !important;
}

/* overrides addresses, numbers, etc. being linked */

span.apple-override-header a {
  color: #ffffff !important;
  text-decoration: none !important;
}

span.apple-override-hidden a {
  color: #008cdd !important;
  text-decoration: none !important;
}

span.apple-override-dark a {
  color: #292e31 !important;
  text-decoration: none !important;
}

span.apple-override-light a {
  color: #77858c !important;
  text-decoration: none !important;
}

</style>
  </head>
  <body bgcolor="f9fafa" style="border: 0; margin: 0; padding: 0; min-width: 100%;" override="fix">

    <!-- background -->
    <table border="0" cellpadding="0" cellspacing="0" width="100%">
      <tbody>
        <tr>
          <td bgcolor="f9fafa" style="border: 0; margin: 0; padding: 0;">

            <!-- header -->
            <table style="background-color: #008cdd;" border="0" cellpadding="0" cellspacing="0" width="100%">
              <tbody>
                <tr>
                  <td align="center" style="border: 0; margin: 0; padding: 0;">

                    <!-- preheader -->
                    <table border="0" cellpadding="0" cellspacing="0" width="100%">
                      <tbody>
                        <tr>
                          <td align="center" style="border: 0; margin: 0; padding: 0;">
                            <table align="center" border="0" cellpadding="0" cellspacing="0" class="width" width="500">
                              <tbody>
                                <tr>
                                  <td align="center" height="20" style="border: 0; margin: 0; padding: 0; font-size: 1px; line-height: 1px; mso-line-height-rule: exactly; color: #008cdd; font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;">
                                    {{ trans('email.thanks_for_total', ['total' => $payment->total]) }} <span class="apple-override-hidden" style="border: 0; margin: 0; padding: 0; font-size: 1px; line-height: 1px; mso-line-height-rule: exactly; color: #008cdd; font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;">{{ $settings['companyName'] }}</span>.
                                  </td>
                                </tr>
                              </tbody>
                            </table>
                          </td>
                        </tr>
                      </tbody>
                    </table>
                    <!-- /preheader -->

                    <!-- banner -->
                    <table border="0" cellpadding="0" cellspacing="0" class="width" width="500">
                      <tbody>
                        <tr>
                          <td height="7" style="border: 0; margin: 0; padding: 0; font-size: 1px; line-height: 1px; mso-line-height-rule: exactly;" width="100%">
                            <div class="clear" style="height: 7px; width: 1px;">&nbsp;</div>
                          </td>
                        </tr>
                        <tr>
                          <td class="banner" style="border: 0; margin: 0; padding: 0; font-size: 1px; line-height: 1px; mso-line-height-rule: exactly;" valign="middle">
                            <table border="0" cellpadding="0" cellspacing="0" width="100%">
                              <tr>
                                <td class="perm-padding" style="border: 0; margin: 0; padding: 0; font-size: 1px; line-height: 1px; mso-line-height-rule: exactly;" width="20">
                                  <div class="clear" style="height: 1px; width: 20px;"></div>
                                </td>
                                <td style="border: 0; margin: 0; padding: 0;" width="100%">
                                  <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                    <tr>
                                      <td height="22" style="border: 0; margin: 0; padding: 0; font-size: 1px; line-height: 1px; mso-line-height-rule: exactly;" width="100%">
                                        <div class="clear" style="height: 22px; width: 1px;">&nbsp;</div>
                                      </td>
                                    </tr>
                                    <tr>
                                      <td align="center" class="title" style="border: 0; margin: 0; padding: 0; font-size: 1px; line-height: 1px; mso-line-height-rule: exactly; color: #ffffff; font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; font-size: 22px; line-height: 25px; text-shadow: 0 1px 1px #007ec6;">
                                          <span class="apple-override" style="color: #ffffff; font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; font-size: 22px; line-height: 25px;">${{ $payment->total }}</span> <span style="color: #ffffff; font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; font-size: 22px; line-height: 25px; opacity: 0.75;">{{ trans('email.thanks_for_total') }}</span> <a href="https://azizisearch.com/" style="color: #ffffff; font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; font-size: 22px; line-height: 25px; text-decoration: none;" target="_blank" rel="noreferrer"><span class="apple-override-header" style="color: #ffffff; font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; font-size: 22px; line-height: 25px; text-decoration: none;">{{ $settings['companyName'] }}</span></a>
                                      </td>
                                    </tr>

                                    
  <!-- card -->
  <tr>
    <td height="13" style="border: 0; margin: 0; padding: 0; font-size: 1px; line-height: 1px; mso-line-height-rule: exactly;" width="100%">
      <div class="clear" style="height: 13px; width: 1px;">&nbsp;</div>
    </td>
  </tr>
  <tr>
    <td align="center" height="1" style="border: 0; margin: 0; padding: 0; font-size: 1px; line-height: 1px; mso-line-height-rule: exactly;" width="100%">
      <table align="center" border="0" cellpadding="0" cellspacing="0" width="200">
        <tbody>
        <tr>
          <td bgcolor="#007ec6" style="border: 0; margin: 0; padding: 0; font-size: 1px; line-height: 1px; mso-line-height-rule: exactly;">
            <div class="clear" style="height: 1px; width: 200px;">&nbsp;</div>
          </td>
        </tr>
        </tbody>
      </table>
    </td>
  </tr>
  <tr>
    <td height="18" style="border: 0; margin: 0; padding: 0; font-size: 1px; line-height: 1px; mso-line-height-rule: exactly;" width="100%">
      <div class="clear" style="height: 18px; width: 1px;">&nbsp;</div>
    </td>
  </tr>
  <tr>
    <td align="center" style="border: 0; margin: 0; padding: 0; font-size: 1px; line-height: 1px; mso-line-height-rule: exactly;" width="100%">
      <table border="0" cellpadding="0" cellspacing="0" class="card card-mastercard">
        <tbody>
        <tr class="card-light">
            <td style="border: 0; margin: 0; padding: 0; mso-line-height-rule: exactly; vertical-align: middle; font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; font-size: 13px; line-height: 17px;" valign="middle">
              <span style="color: #ffffff; font-size: 14px; line-height: 14px;">{{ $user->username }}</span>
            </td>
            <td style="border: 0; margin: 0; padding: 0; font-size: 1px; line-height: 1px; mso-line-height-rule: exactly;" width="6">
              <div class="clear" style="height: 1px; width: 6px;">&nbsp;</div>
            </td>
            <td style="border: 0; margin: 0; padding: 0; mso-line-height-rule: exactly; vertical-align: middle;" valign="middle">
              <span style="font-size: 14px; line-height: 14px;">&mdash;</span>
            </td>
            <td style="border: 0; margin: 0; padding: 0; font-size: 1px; line-height: 1px; mso-line-height-rule: exactly;" width="6">
              <div class="clear" style="height: 1px; width: 6px;">&nbsp;</div>
            </td>

            <td class="card-type" style="border: 0; margin: 0; padding: 0; mso-line-height-rule: exactly;" valign="top">
              <span class="retina">
                <img alt="Mastercard" height="16" src="https://stripe-images.s3.amazonaws.com/emails/receipt_assets/card/mastercard-light@2x.png" style="border: 0; margin: 0; padding: 0;" width="75" />
              </span>
            </td>
            <td style="border: 0; margin: 0; padding: 0; font-size: 1px; line-height: 1px; mso-line-height-rule: exactly;" width="6">
              <div class="clear" style="height: 1px; width: 6px;">&nbsp;</div>
            </td>
          <td class="card-digits" style="color: #ffffff; border: 0; margin: 0; padding: 0; mso-line-height-rule: exactly; font-family: 'Lucida Console', monospace; font-size: 14px; line-height: 14px; text-shadow: 0 1px 1px #007ec6; vertical-align: middle;" valign="middle">
            <span style="color: #ffffff; font-family: 'Lucida Console', monospace; font-size: 14px; line-height: 14px;">2095</span>
          </td>
        </tr>
        </tbody>
      </table>

    </td>
  </tr>
  <!-- /card -->


                                  </table>
                                </td>
                                <td class="perm-padding" style="border: 0; margin: 0; padding: 0; font-size: 1px; line-height: 1px; mso-line-height-rule: exactly;" width="20">
                                  <div class="clear" style="height: 1px; width: 20px;"></div>
                                </td>
                              </tr>
                            </table>
                          </td>
                        </tr>
                        <tr>
                          <td height="27" style="border: 0; margin: 0; padding: 0; font-size: 1px; line-height: 1px; mso-line-height-rule: exactly;" width="100%">
                            <div class="clear" style="height: 27px; width: 1px;">&nbsp;</div>
                          </td>
                        </tr>
                      </tbody>
                    </table>
                    <!-- /banner -->

                    <!-- subbanner -->
                    <table bgcolor="#007ec6" border="0" cellpadding="0" cellspacing="0" width="100%">
                      <tbody>
                        <tr>
                          <td align="center" style="border: 0; margin: 0; padding: 0; font-size: 1px; line-height: 1px; mso-line-height-rule: exactly;">
                            <table class="width" border="0" cellpadding="0" cellspacing="0" width="500">
                              <tbody>
                                <tr>
                                  <td colspan="4" height="8" style="border: 0; margin: 0; padding: 0; font-size: 1px; line-height: 1px; mso-line-height-rule: exactly;" width="100%">
                                    <div class="clear" style="height: 8px; width: 1px;">&nbsp;</div>
                                  </td>
                                </tr>
                                <tr>
                                  <td class="perm-padding" style="border: 0; margin: 0; padding: 0; font-size: 1px; line-height: 1px; mso-line-height-rule: exactly;" width="20">
                                    <div class="clear" style="height: 1px 20px;"></div>
                                  </td>
                                  <td align="left" class="subbanner-item font-small" style="border: 0; margin: 0; padding: 0; font-size: 1px; line-height: 1px; mso-line-height-rule: exactly; color: #ffffff; font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; font-size: 13px; line-height: 17px; text-shadow: 0 1px 1px #007ec6;" width="230">
                                    <span
                                      class="apple-override-header"
                                      style="border: 0; margin: 0; padding: 0; font-size: 1px; line-height: 1px; mso-line-height-rule: exactly; color: #ffffff; font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; font-size: 13px; line-height: 17px; text-shadow: 0 1px 1px #007ec6;"
                                      >
                                        {{ get_readable_time($payment->created_at, 'F d, Y') }}
                                    </span>
                                  </td>
                                  <td align="right" class="subbanner-item font-small" style="border: 0; margin: 0; padding: 0; font-size: 1px; line-height: 1px; mso-line-height-rule: exactly; color: #ffffff; font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; font-size: 13px; line-height: 17px; text-shadow: 0 1px 1px #007ec6;" width="230">
                                    <span class="apple-override-header" style="border: 0; margin: 0; padding: 0; font-size: 1px; line-height: 1px; mso-line-height-rule: exactly; color: #ffffff; font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; font-size: 13px; line-height: 17px; text-shadow: 0 1px 1px #007ec6;">{{ trans('email.ref_id', ['id' => $payment->id]) }}</span>
                                  </td>
                                  <td class="perm-padding" style="border: 0; margin: 0; padding: 0; font-size: 1px; line-height: 1px; mso-line-height-rule: exactly;" width="20">
                                    <div class="clear" style="height: 1px 20px;"></div>
                                  </td>
                                </tr>
                                <tr>
                                  <td colspan="4" height="8" style="border: 0; margin: 0; padding: 0; font-size: 1px; line-height: 1px; mso-line-height-rule: exactly;" width="100%">
                                    <div class="clear" style="height: 8px; width: 1px;">&nbsp;</div>
                                  </td>
                                </tr>
                              </tbody>
                            </table>
                          </td>
                        </tr>
                      </tbody>
                    </table>
                    <!-- /subbanner -->

                  </td>
                </tr>
              </tbody>
            </table>
            <!-- /header -->

              <!-- summary -->
<table bgcolor="ffffff" border="0" cellpadding="0" cellspacing="0" style="border-bottom: 1px solid #e4e6e8;" width="100%">
  <tbody>
    <tr>
      <td align="center" style="border: 0; margin: 0; padding: 0;">
        <table border="0" cellpadding="0" cellspacing="0" class="width" width="500">
          <tbody>
            <tr>
              <td class="temp-padding" style="border: 0; margin: 0; padding: 0; mso-line-height-rule: exactly; font-size: 1px; line-height: 1px;">
                <div class="clear" style="height: 1px; width: 20px;"></div>
              </td>
              <td style="border: 0; margin: 0; padding: 0; mso-line-height-rule: exactly; font-size: 1px; line-height: 1px;" width="460">
                <table border="0" cellpadding="0" cellspacing="0" width="100%">
                  <tbody>

                    <!-- title -->
                    <tr>
                      <td colspan="5" height="12" style="border: 0; margin: 0; padding: 0; mso-line-height-rule: exactly; font-size: 1px; line-height: 1px;">
                        <div class="clear" style="height: 12px; width: 1px;">&nbsp;</div>
                      </td>
                    </tr>
                    <tr class="summary-item">
                      <td class="summary-padding" style="border: 0; margin: 0; padding: 0; font-size: 1px; line-height: 1px;" width="1">
                        <div class="clear" style="height: 1px; width: 1px;"></div>
                      </td>
                      <td align="left" class="font-small" style="border: 0; margin: 0; padding: 0; font-size: 1px; line-height: 1px; color: #77858c; font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; font-size: 12px; font-weight: bold; line-height: 20px;" width="100%">
                        {{ trans('email.desc') }}
                      </td>
                      <td style="border: 0; margin: 0; padding: 0; font-size: 1px; line-height: 1px;" width="10">
                        <div class="clear" style="height: 1px; width: 10px;"></div>
                      </td>
                      <td align="right" class="font-small" style="border: 0; margin: 0; padding: 0; font-size: 1px; line-height: 1px; color: #77858c; font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; font-size: 12px; font-weight: bold; line-height: 20px;" width="120">
                        {{ trans('email.amount') }}
                      </td>
                      <td class="summary-padding" style="border: 0; margin: 0; padding: 0; font-size: 1px; line-height: 1px;" width="1">
                        <div class="clear" style="height: 1px; width: 1px;"></div>
                      </td>
                    </tr>
                    <tr>
                      <td colspan="5" height="12" style="border: 0; margin: 0; padding: 0; font-size: 1px; line-height: 1px; mso-line-height-rule: exactly; border-bottom: 1px solid #eaeff2;">
                        <div class="clear" style="height: 12px; width: 1px;">&nbsp;</div>
                      </td>
                    </tr>
                    <!-- /title -->

                      <!-- item -->
                      <tr>
                        <td colspan="5" height="11" style="border: 0; margin: 0; padding: 0; font-size: 1px; line-height: 1px; mso-line-height-rule: exactly; border-top: 1px solid #eaeff2;">
                          <div class="clear" style="height: 11px; width: 1px;">&nbsp;</div>
                        </td>
                      </tr>
                      <tr class="summary-item">
                        <td class="summary-padding" style="border: 0; margin: 0; padding: 0; font-size: 1px; line-height: 1px;" width="1">
                          <div class="clear" style="height: 1px; width: 1px;"></div>
                        </td>
                        <td align="left" class="font-medium" style="border: 0; margin: 0; padding: 0; font-size: 1px; line-height: 1px; color: #292e31; font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; font-size: 14px; font-weight: normal; line-height: 17px;" width="100%">
                          <span class="apple-override-dark" style="border: 0; margin: 0; padding: 0;">{{ trans('email.add_funds', ['name' => $settings['siteName']]) }}</span>
                        </td>
                        <td style="border: 0; margin: 0; padding: 0; font-size: 1px; line-height: 1px;" width="10">
                          <div class="clear" style="height: 1px; width: 10px;"></div>
                        </td>
                        <td align="right" class="font-medium" style="border: 0; margin: 0; padding: 0; font-size: 1px; line-height: 1px; color: #292e31; font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; font-size: 14px; font-weight: normal; line-height: 17px;" width="120">
                          ${{ $payment->total }}
                        </td>
                        <td class="summary-padding" style="border: 0; margin: 0; padding: 0; font-size: 1px; line-height: 1px;" width="1">
                          <div class="clear" style="height: 1px; width: 1px;"></div>
                        </td>
                      </tr>
                      <tr>
                        <td colspan="5" height="12" style="border: 0; margin: 0; padding: 0; font-size: 1px; line-height: 1px; mso-line-height-rule: exactly;">
                          <div class="clear" style="height: 12px; width: 1px;">&nbsp;</div>
                        </td>
                      </tr>
                      <!-- /item -->

                    <!-- breakdown -->
                    <tr>
                      <td colspan="5" align="right" style="border: 0; margin: 0; padding: 0; font-size: 1px; line-height: 1px; mso-line-height-rule: exactly; border-top: 2px solid #eaeff2;">
                        <table border="0" cellpadding="0" cellspacing="0" class="width" width="320">
                          <tbody>

                            <!-- amount -->
                            <tr>
                              <td colspan="5" height="11" style="border: 0; margin: 0; padding: 0; font-size: 1px; line-height: 1px; mso-line-height-rule: exactly;">
                                <div class="clear" style="height: 11px; width: 1px;">&nbsp;</div>
                              </td>
                            </tr>
                            <tr class="summary-item">
                              <td class="summary-padding" style="border: 0; margin: 0; padding: 0; font-size: 1px; line-height: 1px;" width="1">
                                <div class="clear" style="height: 1px; width: 1px;"></div>
                              </td>
                              <td align="left" style="border: 0; margin: 0; padding: 0; font-size: 1px; line-height: 1px; color: #292e31; font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; font-size: 12px; font-weight: bold; line-height: 17px;" width="100">
                                {{ trans('email.total') }}
                              </td>
                              <td style="border: 0; margin: 0; padding: 0; font-size: 1px; line-height: 1px;" width="10">
                                <div class="clear" style="height: 1px; width: 10px;"></div>
                              </td>
                              <td align="right" class="summary-total width" style="border: 0; margin: 0; padding: 0; font-size: 1px; line-height: 1px; color: #292e31; font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; font-size: 16px; font-weight: bold; line-height: 17px;" width="208">
                                ${{ $payment->total }}
                              </td>
                              <td class="summary-padding" style="border: 0; margin: 0; padding: 0; font-size: 1px; line-height: 1px;" width="1">
                                <div class="clear" style="height: 1px; width: 1px;"></div>
                              </td>
                            </tr>
                            <tr>
                              <td colspan="5" height="12" style="border: 0; margin: 0; padding: 0; font-size: 1px; line-height: 1px; mso-line-height-rule: exactly;">
                                <div class="clear" style="height: 12px; width: 1px;">&nbsp;</div>
                              </td>
                            </tr>
                            <!-- /amount -->

                          </tbody>
                        </table>
                      </td>
                    </tr>
                    <!-- /breakdown -->

                  </tbody>
                </table>
              </td>
              <td class="temp-padding" style="border: 0; margin: 0; padding: 0; mso-line-height-rule: exactly; font-size: 1px; line-height: 1px;">
                <div class="clear" style="height: 1px; width: 20px;"></div>
              </td>
            </tr>
          </tbody>
        </table>
      </td>
    </tr>
  </tbody>
</table>
<!-- /summary -->


            
<!-- help -->
<table border="0" cellpadding="0" cellspacing="0" width="100%">
  <tbody>
  <tr>
    <td align="center" style="border: 0; margin: 0; padding: 0;">
      <table border="0" cellpadding="0" cellspacing="0" class="width" width="500">
        <tbody>
        <tr>
          <td colspan="3" height="37" style="border: 0; margin: 0; padding: 0; mso-line-height-rule: exactly;">
            <div class="clear" style="height: 37px; width: 1px;">&nbsp;</div>
          </td>
        </tr>
        <tr>
          <td style="border: 0; margin: 0; padding: 0; font-size: 1px; line-height: 1px; mso-line-height-rule: exactly;">
            <div class="clear" style="height: 1px; width: 20px;"></div>
          </td>

            <td align="center" class="font-large" style="color: #515f66; border: 0; margin: 0; padding: 0; font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; font-size: 15px; line-height: 21px;">

              {{ trans('email.have_question') }} <a href="{{ url('/') }}" style="border: 0; margin: 0; padding: 0; color: #515f66; font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; text-decoration: none;" target="_blank" rel="noreferrer"><span style="border: 0; margin: 0; padding: 0; color: #008cdd; text-decoration: none;">{{ trans('email.visti_support') }}</span></a> {{ trans('email.or') }} <a href="{{ $settings['siteEmail'] }}" style="border: 0; margin: 0; padding: 0; color: #515f66; font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; text-decoration: none;" target="_blank" rel="noreferrer"><span style="border: 0; margin: 0; padding: 0; color: #008cdd; text-decoration: none;">{{ trans('email.send_an_email') }}</span></a>.
            </td>

          <td style="border: 0; margin: 0; padding: 0; font-size: 1px; line-height: 1px; mso-line-height-rule: exactly;">
            <div class="clear" style="height: 1px; width: 20px;"></div>
          </td>
        </tr>
        <tr>
          <td colspan="3" height="37" style="border: 0; margin: 0; padding: 0; mso-line-height-rule: exactly;">
            <div class="clear" style="height: 37px; width: 1px;">&nbsp;</div>
          </td>
        </tr>
        <tr>
          <td colspan="3" align="center" height="1" style="border: 0; margin: 0; padding: 0; font-size: 1px; line-height: 1px; mso-line-height-rule: exactly;">
            <table align="center" border="0" cellpadding="0" cellspacing="0" width="200">
              <tbody>
              <tr>
                <td bgcolor="edeff0" style="border: 0; margin: 0; padding: 0; font-size: 1px; line-height: 1px; mso-line-height-rule: exactly;">
                  <div class="clear" style="height: 1px; width: 200px;">&nbsp;</div>
                </td>
              </tr>
              </tbody>
            </table>
          </td>
        </tr>
        </tbody>
      </table>
    </td>
  </tr>
  </tbody>
</table>
<!-- /help -->

            <!-- footer -->
            <table border="0" cellpadding="0" cellspacing="0" width="100%">
              <tbody>
                <tr>
                  <td align="center" style="border: 0; margin: 0; padding: 0;">
                    <table border="0" cellpadding="0" cellspacing="0" class="width" width="500">
                      <tbody>
                        <tr>
                          <td colspan="3" height="28" style="border: 0; margin: 0; padding: 0; font-size: 1px; line-height: 1px; mso-line-height-rule: exactly;">
                            <div class="clear" style="height: 28px; width: 1px;">&nbsp;</div>
                          </td>
                        </tr>


                        <tr>
                          <td class="perm-padding" style="border: 0; margin: 0; padding: 0; font-size: 1px; line-height: 1px;" width="20">
                            <div class="clear" style="height: 1px; width: 20px;"></div>
                          </td>
                          <td align="center" class="font-small" style="border: 0; margin: 0; padding: 0; color: #959fa5; font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; font-size: 13px; line-height: 17px;">
                            {{ trans('email.you_received_email') }} <a href="{{ route('home') }}" style="border: 0; margin: 0; padding: 0; color: #008cdd; font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; text-decoration: none;" target="_blank" rel="noreferrer"><span style="border: 0; margin: 0; padding: 0; color: #008cdd; text-decoration: none;">{{ $settings['siteName'] }}</span></a> {{ trans('email.account') }}.
                          </td>
                          <td class="perm-padding" style="border: 0; margin: 0; padding: 0; font-size: 1px; line-height: 1px;" width="20">
                            <div class="clear" style="height: 1px; width: 20px;"></div>
                          </td>
                        </tr>

                        <tr>
                          <td colspan="3" height="28" style="border: 0; margin: 0; padding: 0; font-size: 1px; line-height: 1px; mso-line-height-rule: exactly;">
                            <div class="clear" style="height: 28px; width: 1px;">&nbsp;</div>
                          </td>
                        </tr>
                      </tbody>
                    </table>
                  </td>
                </tr>
              </tbody>
            </table>
            <!-- /footer -->

          </td>
        </tr>
      </tbody>
    </table>
    <!-- /background -->

  </body>
</html>
