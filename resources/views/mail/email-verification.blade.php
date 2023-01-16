<div style="background-color: #0D0B14; height: 100%; width: 100%">
    <div style="padding: 40px">
        <table style="align-items: center; text-align: center; width: 100%">
            <tr>
                <td style="align-items: center; text-align: center">
                    <img src="{{$message->embed(public_path('/images/quote-icon.png'))}}" title="Quote Icon"
                         width="22px"
                         height="22px"
                         alt="not found"/>
                    <p style="color: #DDCCAA">MOVIE QUOTES</p>
                </td>
            </tr>
        </table>
        <br/>
        <br/>
        <table>
            <tr>
                <td style="color: white">Holla {{$user->username}}!</td>
            </tr>
            <br/>
            <tr>
                <td style="color: white; margin-top: 4px; margin-bottom: 4px">Thanks for joining Movie quotes! We
                    really
                    appreciate it. Please click the button
                    below to verify your
                    account:
                </td>
            </tr>
            <br/>
            <tr>
                <td>
                    <a
                        href="{{env('FRONTEND_URL')}}/email/{{$user->token}}"
                        style="text-decoration: none; padding: 10px; border-radius: 6px;  color: white; background-color: #E31221;">
                        Verify account
                    </a>
            </tr>
            <br/>
            <tr>
                <td>
                    <p style="color: white">
                        If clicking doesn't work, you can try
                        copying
                        and pasting it to your browser:
                    </p>
                </td>
            </tr>
            <br/>
            <tr>
                <td>
                    <a style="color: #DDCCAA">{{env('FRONTEND_URL')}}/email/{{$user->token}}</a>
                </td>
            </tr>
            <br/>
            <tr>
                <td>
                    <p style="color: white">
                        If you have any problems, please contact
                        us:
                        support@moviequotes.ge
                    </p>
                </td>
            </tr>
            <br/>
            <tr>
                <td>
                    <p style="color: white">MovieQuotes crew</p>
                </td>
            </tr>
        </table>
    </div>
</div>

