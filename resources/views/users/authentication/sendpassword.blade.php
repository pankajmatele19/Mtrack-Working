@if (isset($template))
    <!DOCTYPE html>
    <html>
    <div style="font-family: Helvetica,Arial,sans-serif;min-width:1000px;overflow:auto;line-height:2">
        <div style="margin:50px auto;width:70%;padding:20px 0">
            <div style="border-bottom:1px solid #eee; text-align:center;">
                <h1><a href="{{ env('FRONT_BASE_URL') }}"
                        style="font-size:1.4em;color: #00466a;text-decoration:none;font-weight:600">{{ config('app.name') }}</a>
                </h1>
            </div>
            <div style="text-align:center;">
                <h2>Password Reset</h2>
                <p style="font-size: 17px;">If you've lost your password or wish to reset it, use the below link to get
                    started.</p>
                <a href='{{ $template }}'
                    style="background: #00466a;margin: 0 auto;width: max-content;padding:10px;color: #fff;border-radius: 4px;cursor:pointer; text-decoration:none">Reset
                    Your Password</a>
                <p>If you did not request a password reset, you can safely ignore this email.<br> Only a person with
                    access to your email can reset your account password.</p>
                <hr style="border:none;border-top:1px solid #eee" />
                <div style="float:right;padding:8px 0;color:#aaa;font-size:0.8em;line-height:1;font-weight:300">
                </div>
            </div>
        </div>
    </div>

    </html>
@elseif (isset($setpassword))
    Your mTrack password is reset:<br>
    New password: <h1>{{ $setpassword }}</h1>
@elseif(isset($invitation_msg))
    <h3>mTrack</h3>

    {!! $invitation_msg !!}

    username:- Use your email as username <br>
    password:- <strong>{{ $password }}</strong>
@else
    <h1>Your password for Login</h1>

    <h3>mTrack</h3>
    username:- Use your email as username <br>
    password:- <strong>{{ $password }}</strong>
@endif
