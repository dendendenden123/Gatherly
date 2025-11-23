<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Church Transfer Request</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        :root {
            --primary: #2ecc71;
            --secondary: #27ae60;
            --accent: #e74c3c;
            --light: #f9f9f9;
            --dark: #333;
            --gray: #777;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            background-color: #f5f5f5;
            color: var(--dark);
            line-height: 1.6;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }

        header {
            text-align: center;
            margin-bottom: 30px;
            padding: 20px 0;
            border-bottom: 2px solid var(--primary);
        }

        h1 {
            color: var(--primary);
            margin-bottom: 10px;
        }

        .subtitle {
            color: var(--gray);
            font-size: 1.1rem;
        }

        .form-container {
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            padding: 30px;
        }

        .form-group {
            margin-bottom: 25px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: var(--dark);
        }

        input,
        select,
        textarea {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 16px;
            transition: border-color 0.3s;
        }

        input:focus,
        select:focus,
        textarea:focus {
            border-color: var(--primary);
            outline: none;
            box-shadow: 0 0 0 2px rgba(46, 204, 113, 0.2);
        }

        textarea {
            min-height: 120px;
            resize: vertical;
        }

        .required::after {
            content: " *";
            color: var(--accent);
        }

        .submit-btn {
            background-color: var(--primary);
            color: white;
            border: none;
            padding: 14px 24px;
            font-size: 16px;
            font-weight: 600;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s;
            width: 100%;
        }

        .submit-btn:hover {
            background-color: var(--secondary);
        }

        .form-note {
            margin-top: 20px;
            padding: 15px;
            background-color: #f8f9fa;
            border-left: 4px solid var(--primary);
            font-size: 14px;
            color: var(--gray);
        }

        footer {
            text-align: center;
            margin-top: 30px;
            padding: 20px 0;
            color: var(--gray);
            font-size: 14px;
        }

        @media (max-width: 600px) {
            .container {
                padding: 10px;
            }

            .form-container {
                padding: 20px;
            }
        }

        .button-group {
            display: flex;
            gap: 12px;
            margin-top: 20px;
        }

        .btn {
            padding: 10px 18px;
            font-size: 14px;
            font-weight: 600;
            border-radius: 6px;
            border: none;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
            transition: background 0.3s ease, color 0.3s ease;
        }

        /* Primary Button */
        .btn-primary {
            background-color: var(--primary);
            /* Blue */
            color: white;
        }

        .btn-primary:hover {
            background-color: #1e4fc6;
        }

        /* Secondary Button */
        .btn-secondary {
            background-color: #e5e7eb;
            /* Gray */
            color: #374151;
        }

        .btn-secondary:hover {
            background-color: #d1d5db;
        }
    </style>

</head>

<body>
    <div class="container">
        <header>
            <h1>Church Transfer Request</h1>
            <p class="subtitle">Please complete this form to request a transfer to another locale church</p>
        </header>

        <div class="form-container">
            <form id="transferForm" action="{{route('member.update.transfer') }}" method='POST'>
                @csrf
                @if (session('success'))
                    <script>
                        Swal.fire({
                            icon: 'success',
                            title: 'Success!',
                            text: '{{ session('success') }}',
                            confirmButtonColor: '#3085d6',
                        });
                    </script>
                @endif
                @if ($errors->any())
                    <script>
                        Swal.fire({
                            icon: 'error',
                            title: 'Failed!',
                            text: '{{ $errors->first() }}',
                            confirmButtonColor: '#d63030ff',
                        });
                    </script>
                @endif

                <div class="form-group">
                    <label for="transferDate" class="required">When do you plan to transfer?</label>
                    <input type="date" id="transferDate" name="transferred_when" required>
                </div>

                <div class="form-group">
                    <label for="destinationLocation" class="required">Destination Location</label>
                    <input type="text" id="destinationLocation" name="transferred_to" required>
                </div>

                <div class="form-group">
                    <label for="reasonDetails" class="required">Please provide details about your reason for
                        transfer</label>
                    <textarea id="reasonDetails" name="transfer_reason" required></textarea>
                </div>
                <div class="button-group">
                    <button type="submit" class="btn btn-primary">Submit Transfer Request</button>
                    <a href="{{ route('member') }}" class="btn btn-secondary">Cancel</a>
                </div>

            </form>
        </div>

        <footer>
            <p>&copy; 2023 Church Name. All rights reserved.</p>
        </footer>
    </div>

</body>

</html>