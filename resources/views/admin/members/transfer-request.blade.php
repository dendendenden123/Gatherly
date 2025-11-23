<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - Church Transfer Requests</title>
    <style>
        :root {
            --primary: #2ecc71;
            --secondary: #27ae60;
            --accent: #e74c3c;
            --light: #f9f9f9;
            --dark: #333;
            --gray: #777;
            --light-gray: #f0f0f0;
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
            display: flex;
            min-height: 100vh;
        }
        
        /* Sidebar Styles */
        .sidebar {
            width: 250px;
            background-color: var(--dark);
            color: white;
            padding: 20px 0;
        }
        
        .logo {
            padding: 0 20px 20px;
            border-bottom: 1px solid #444;
            margin-bottom: 20px;
        }
        
        .logo h2 {
            color: var(--primary);
        }
        
        .nav-links {
            list-style: none;
        }
        
        .nav-links li {
            padding: 12px 20px;
            border-left: 4px solid transparent;
            transition: all 0.3s;
        }
        
        .nav-links li.active {
            background-color: rgba(255, 255, 255, 0.1);
            border-left-color: var(--primary);
        }
        
        .nav-links li:hover {
            background-color: rgba(255, 255, 255, 0.05);
        }
        
        .nav-links a {
            color: white;
            text-decoration: none;
            display: flex;
            align-items: center;
        }
        
        .nav-links i {
            margin-right: 10px;
            width: 20px;
            text-align: center;
        }
        
        /* Main Content Styles */
        .main-content {
            flex: 1;
            padding: 20px;
            overflow-y: auto;
        }
        
        .header {
            display: flex;
            justify-content: between;
            align-items: center;
            margin-bottom: 30px;
            padding-bottom: 15px;
            border-bottom: 1px solid #ddd;
        }
        
        .header h1 {
            color: var(--primary);
        }
        
        .user-info {
            display: flex;
            align-items: center;
        }
        
        .user-info img {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            margin-right: 10px;
        }
        
        /* Stats Cards */
        .stats-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }
        
        .stat-card {
            background-color: white;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            text-align: center;
        }
        
        .stat-card h3 {
            font-size: 2rem;
            margin-bottom: 10px;
        }
        
        .stat-card.pending h3 {
            color: #f39c12;
        }
        
        .stat-card.approved h3 {
            color: var(--primary);
        }
        
        .stat-card.rejected h3 {
            color: var(--accent);
        }
        
        .stat-card.total h3 {
            color: var(--dark);
        }
        
        /* Table Styles */
        .table-container {
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
        }
        
        thead {
            background-color: var(--primary);
            color: white;
        }
        
        th, td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid #eee;
        }
        
        tbody tr:hover {
            background-color: var(--light-gray);
        }
        
        .status {
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: bold;
        }
        
        .status.pending {
            background-color: #fff3cd;
            color: #856404;
        }
        
        .status.approved {
            background-color: #d1ecf1;
            color: #0c5460;
        }
        
        .status.rejected {
            background-color: #f8d7da;
            color: #721c24;
        }
        
        .action-buttons {
            display: flex;
            gap: 5px;
        }
        
        .btn {
            padding: 6px 12px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 0.8rem;
            transition: all 0.3s;
        }
        
        .btn-approve {
            background-color: var(--primary);
            color: white;
        }
        
        .btn-reject {
            background-color: var(--accent);
            color: white;
        }
        
        .btn-view {
            background-color: #3498db;
            color: white;
        }
        
        .btn:hover {
            opacity: 0.9;
            transform: translateY(-2px);
        }
        
        /* Modal Styles */
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 1000;
            align-items: center;
            justify-content: center;
        }
        
        .modal-content {
            background-color: white;
            border-radius: 8px;
            width: 90%;
            max-width: 600px;
            max-height: 90vh;
            overflow-y: auto;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
        }
        
        .modal-header {
            padding: 15px 20px;
            background-color: var(--primary);
            color: white;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-radius: 8px 8px 0 0;
        }
        
        .modal-header h3 {
            margin: 0;
        }
        
        .close-btn {
            background: none;
            border: none;
            color: white;
            font-size: 1.5rem;
            cursor: pointer;
        }
        
        .modal-body {
            padding: 20px;
        }
        
        .detail-row {
            display: flex;
            margin-bottom: 15px;
            padding-bottom: 15px;
            border-bottom: 1px solid #eee;
        }
        
        .detail-label {
            font-weight: bold;
            width: 150px;
            color: var(--gray);
        }
        
        .detail-value {
            flex: 1;
        }
        
        .modal-footer {
            padding: 15px 20px;
            display: flex;
            justify-content: flex-end;
            gap: 10px;
            border-top: 1px solid #eee;
        }
        
        /* Responsive Styles */
        @media (max-width: 768px) {
            .container {
                flex-direction: column;
            }
            
            .sidebar {
                width: 100%;
                height: auto;
            }
            
            .stats-container {
                grid-template-columns: 1fr 1fr;
            }
            
            table {
                display: block;
                overflow-x: auto;
            }
        }
        
        @media (max-width: 480px) {
            .stats-container {
                grid-template-columns: 1fr;
            }
            
            .action-buttons {
                flex-direction: column;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Sidebar -->
        <div class="sidebar">
            <div class="logo">
                <h2>Church Admin</h2>
            </div>
            <ul class="nav-links">
                <li class="active"><a href="#"><i>📊</i> Dashboard</a></li>
                <li><a href="#"><i>👥</i> Members</a></li>
                <li><a href="#"><i>📋</i> Transfer Requests</a></li>
                <li><a href="#"><i>⚙️</i> Settings</a></li>
                <li><a href="#"><i>🚪</i> Logout</a></li>
            </ul>
        </div>
        
        <!-- Main Content -->
        <div class="main-content">
            <div class="header">
                <h1>Transfer Requests Management</h1>
                <div class="user-info">
                    <img src="https://ui-avatars.com/api/?name=Admin+User&background=2ecc71&color=fff" alt="Admin User">
                    <span>Admin User</span>
                </div>
            </div>
            
            <!-- Stats Cards -->
            <div class="stats-container">
                <div class="stat-card total">
                    <h3>24</h3>
                    <p>Total Requests</p>
                </div>
                <div class="stat-card pending">
                    <h3>12</h3>
                    <p>Pending</p>
                </div>
                <div class="stat-card approved">
                    <h3>8</h3>
                    <p>Approved</p>
                </div>
                <div class="stat-card rejected">
                    <h3>4</h3>
                    <p>Rejected</p>
                </div>
            </div>
            
            <!-- Requests Table -->
            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Current Church</th>
                            <th>Destination</th>
                            <th>Transfer Date</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>John Smith</td>
                            <td>Grace Community Church</td>
                            <td>Faith Baptist Church</td>
                            <td>2023-11-15</td>
                            <td><span class="status pending">Pending</span></td>
                            <td>
                                <div class="action-buttons">
                                    <button class="btn btn-view" onclick="viewRequest(1)">View</button>
                                    <button class="btn btn-approve" onclick="approveRequest(1)">Approve</button>
                                    <button class="btn btn-reject" onclick="rejectRequest(1)">Reject</button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>Maria Garcia</td>
                            <td>First Methodist</td>
                            <td>St. Mary's Catholic</td>
                            <td>2023-12-01</td>
                            <td><span class="status pending">Pending</span></td>
                            <td>
                                <div class="action-buttons">
                                    <button class="btn btn-view" onclick="viewRequest(2)">View</button>
                                    <button class="btn btn-approve" onclick="approveRequest(2)">Approve</button>
                                    <button class="btn btn-reject" onclick="rejectRequest(2)">Reject</button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>Robert Johnson</td>
                            <td>Hope Church</td>
                            <td>New Life Fellowship</td>
                            <td>2023-10-20</td>
                            <td><span class="status approved">Approved</span></td>
                            <td>
                                <div class="action-buttons">
                                    <button class="btn btn-view" onclick="viewRequest(3)">View</button>
                                    <button class="btn btn-reject" onclick="rejectRequest(3)">Reject</button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>Sarah Williams</td>
                            <td>Calvary Chapel</td>
                            <td>Living Waters Church</td>
                            <td>2023-11-30</td>
                            <td><span class="status rejected">Rejected</span></td>
                            <td>
                                <div class="action-buttons">
                                    <button class="btn btn-view" onclick="viewRequest(4)">View</button>
                                    <button class="btn btn-approve" onclick="approveRequest(4)">Approve</button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>Michael Brown</td>
                            <td>Trinity Church</td>
                            <td>Community Christian</td>
                            <td>2023-12-05</td>
                            <td><span class="status pending">Pending</span></td>
                            <td>
                                <div class="action-buttons">
                                    <button class="btn btn-view" onclick="viewRequest(5)">View</button>
                                    <button class="btn btn-approve" onclick="approveRequest(5)">Approve</button>
                                    <button class="btn btn-reject" onclick="rejectRequest(5)">Reject</button>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
    <!-- Request Detail Modal -->
    <div class="modal" id="requestModal">
        <div class="modal-content">
            <div class="modal-header">
                <h3>Transfer Request Details</h3>
                <button class="close-btn" onclick="closeModal()">&times;</button>
            </div>
            <div class="modal-body">
                <div class="detail-row">
                    <div class="detail-label">Full Name:</div>
                    <div class="detail-value" id="detail-name">John Smith</div>
                </div>
                <div class="detail-row">
                    <div class="detail-label">Current Church:</div>
                    <div class="detail-value" id="detail-current">Grace Community Church</div>
                </div>
                <div class="detail-row">
                    <div class="detail-label">Destination Church:</div>
                    <div class="detail-value" id="detail-destination">Faith Baptist Church</div>
                </div>
                <div class="detail-row">
                    <div class="detail-label">Transfer Date:</div>
                    <div class="detail-value" id="detail-date">2023-11-15</div>
                </div>
                <div class="detail-row">
                    <div class="detail-label">Reason:</div>
                    <div class="detail-value" id="detail-reason">Relocation</div>
                </div>
                <div class="detail-row">
                    <div class="detail-label">Reason Details:</div>
                    <div class="detail-value" id="detail-reason-details">I am moving to a new city for work and would like to transfer to a church closer to my new home.</div>
                </div>
                <div class="detail-row">
                    <div class="detail-label">Contact Email:</div>
                    <div class="detail-value" id="detail-email">john.smith@example.com</div>
                </div>
                <div class="detail-row">
                    <div class="detail-label">Contact Phone:</div>
                    <div class="detail-value" id="detail-phone">(555) 123-4567</div>
                </div>
                <div class="detail-row">
                    <div class="detail-label">Status:</div>
                    <div class="detail-value" id="detail-status"><span class="status pending">Pending</span></div>
                </div>
                <div class="detail-row">
                    <div class="detail-label">Submission Date:</div>
                    <div class="detail-value" id="detail-submission">2023-10-05</div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-approve" onclick="approveCurrent()">Approve</button>
                <button class="btn btn-reject" onclick="rejectCurrent()">Reject</button>
                <button class="btn" onclick="closeModal()">Close</button>
            </div>
        </div>
    </div>
    
    <script>
        // Sample data for demonstration
        const requests = {
            1: {
                name: "John Smith",
                currentChurch: "Grace Community Church",
                destination: "Faith Baptist Church",
                date: "2023-11-15",
                reason: "Relocation",
                reasonDetails: "I am moving to a new city for work and would like to transfer to a church closer to my new home.",
                email: "john.smith@example.com",
                phone: "(555) 123-4567",
                status: "pending",
                submission: "2023-10-05"
            },
            2: {
                name: "Maria Garcia",
                currentChurch: "First Methodist",
                destination: "St. Mary's Catholic",
                date: "2023-12-01",
                reason: "Family reasons",
                reasonDetails: "My family has decided to join a Catholic church to align with our heritage and traditions.",
                email: "maria.garcia@example.com",
                phone: "(555) 987-6543",
                status: "pending",
                submission: "2023-10-07"
            },
            3: {
                name: "Robert Johnson",
                currentChurch: "Hope Church",
                destination: "New Life Fellowship",
                date: "2023-10-20",
                reason: "Ministry opportunities",
                reasonDetails: "I feel called to serve in the music ministry at New Life Fellowship.",
                email: "robert.johnson@example.com",
                phone: "(555) 456-7890",
                status: "approved",
                submission: "2023-09-15"
            },
            4: {
                name: "Sarah Williams",
                currentChurch: "Calvary Chapel",
                destination: "Living Waters Church",
                date: "2023-11-30",
                reason: "Personal preference",
                reasonDetails: "I prefer the worship style and community at Living Waters Church.",
                email: "sarah.williams@example.com",
                phone: "(555) 234-5678",
                status: "rejected",
                submission: "2023-10-01"
            },
            5: {
                name: "Michael Brown",
                currentChurch: "Trinity Church",
                destination: "Community Christian",
                date: "2023-12-05",
                reason: "Relocation",
                reasonDetails: "My job is transferring me to a different state next month.",
                email: "michael.brown@example.com",
                phone: "(555) 345-6789",
                status: "pending",
                submission: "2023-10-10"
            }
        };
        
        let currentRequestId = null;
        
        // View request details
        function viewRequest(id) {
            currentRequestId = id;
            const request = requests[id];
            
            document.getElementById('detail-name').textContent = request.name;
            document.getElementById('detail-current').textContent = request.currentChurch;
            document.getElementById('detail-destination').textContent = request.destination;
            document.getElementById('detail-date').textContent = request.date;
            document.getElementById('detail-reason').textContent = request.reason;
            document.getElementById('detail-reason-details').textContent = request.reasonDetails;
            document.getElementById('detail-email').textContent = request.email;
            document.getElementById('detail-phone').textContent = request.phone;
            document.getElementById('detail-submission').textContent = request.submission;
            
            // Update status display
            const statusElement = document.getElementById('detail-status');
            statusElement.innerHTML = `<span class="status ${request.status}">${request.status.charAt(0).toUpperCase() + request.status.slice(1)}</span>`;
            
            // Show modal
            document.getElementById('requestModal').style.display = 'flex';
        }
        
        // Close modal
        function closeModal() {
            document.getElementById('requestModal').style.display = 'none';
        }
        
        // Approve request
        function approveRequest(id) {
            if (confirm("Are you sure you want to approve this transfer request?")) {
                requests[id].status = "approved";
                updateUI();
                alert("Transfer request approved successfully!");
            }
        }
        
        // Reject request
        function rejectRequest(id) {
            if (confirm("Are you sure you want to reject this transfer request?")) {
                requests[id].status = "rejected";
                updateUI();
                alert("Transfer request rejected.");
            }
        }
        
        // Approve current request (from modal)
        function approveCurrent() {
            if (currentRequestId) {
                approveRequest(currentRequestId);
                closeModal();
            }
        }
        
        // Reject current request (from modal)
        function rejectCurrent() {
            if (currentRequestId) {
                rejectRequest(currentRequestId);
                closeModal();
            }
        }
        
        // Update UI after status changes
        function updateUI() {
            // In a real application, this would update the table and stats
            // For this demo, we'll just reload the page to show changes
            location.reload();
        }
        
        // Close modal if clicking outside
        window.onclick = function(event) {
            const modal = document.getElementById('requestModal');
            if (event.target === modal) {
                closeModal();
            }
        }
    </script>
</body>
</html>