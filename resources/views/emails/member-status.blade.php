<!DOCTYPE html>
<html>
<head>
    <title>Member Status Update</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #e0e0e0;
            border-radius: 5px;
        }
        .header {
            background-color: #4a90e2;
            color: white;
            padding: 20px;
            text-align: center;
            border-radius: 5px 5px 0 0;
        }
        .content {
            padding: 20px;
        }
        .status-box {
            background-color: #f8f9fa;
            border-left: 4px solid #4a90e2;
            padding: 15px;
            margin: 15px 0;
        }
        .footer {
            margin-top: 20px;
            font-size: 0.9em;
            color: #666;
            text-align: center;
            border-top: 1px solid #e0e0e0;
            padding-top: 15px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Gatherly Member Status Update</h1>
        </div>
        
        <div class="content">
            @if($isMinister)
                <p>Dear Minister,</p>
                <p>This is to inform you about the status update for one of the members:</p>
                
                <div class="status-box">
                    <p><strong>Member Name:</strong> {{ $user->first_name }} {{ $user->last_name }}</p>
                    <p><strong>Email:</strong> {{ $user->email }}</p>
                    <p><strong>Status:</strong> 
                        <span style="font-weight: bold; color: {{ $status === 'active' ? '#28a745' : ($status === 'partially-active' ? '#ffc107' : '#dc3545') }}">
                            {{ ucfirst(str_replace('-', ' ', $status)) }}
                        </span>
                    </p>
                </div>
                
                <p>Please follow up with the member as appropriate.</p>
            @else
                <p>Dear {{ $user->first_name }},</p>
                
                <p>We hope this message finds you well. We wanted to update you about your member status in our system.</p>
                
                <div class="status-box">
                    <p>Your current status is: 
                        <span style="font-weight: bold; color: {{ $status === 'active' ? '#28a745' : ($status === 'partially-active' ? '#ffc107' : '#dc3545') }}">
                            {{ ucfirst(str_replace('-', ' ', $status)) }}
                        </span>
                    </p>
                    
                    @if($status === 'inactive')
                        <p>We notice you haven't attended any worship services last month. We'd love to see you at our upcoming services.</p>
                    @elseif($status === 'partially-active')
                        <p>Thank you for attending some of our services last month. We encourage you to join us more regularly.</p>
                    @endif
                </div>
                
                <p>If you have any questions or need assistance, please don't hesitate to reach out to us.</p>
            @endif
            
            <p>Thank you for being part of our community.</p>
            
            <p>Warm regards,<br>The Gatherly Team</p>
        </div>
        
        <div class="footer">
            <p>© {{ date('Y') }} Gatherly. All rights reserved.</p>
            <p>This is an automated message, please do not reply to this email.</p>
        </div>
    </div>
</body>
</html>
