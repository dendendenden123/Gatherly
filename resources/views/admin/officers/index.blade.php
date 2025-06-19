@extends('layouts.admin')
@section('styles')
    <link href="{{ asset('css/admin/officers/index.css') }}" rel="stylesheet">
@endsection

@section('header')
    <div class="header">
        <div class="header-title">
            <h1>Gatherly - Officer Management</h1>
        </div>
        <div class="user-avatar"></div>
    </div>
@endsection


@section('content')
    <!-- Main Content -->
    <div class="content">
        <!-- Dashboard Cards -->
        <div class="dashboard-cards">
            <div class="dashboard-card">
                <div class="card-header">
                    <div class="card-title">Total Officers</div>
                    <i class="fas fa-user-tie"></i>
                </div>
                <div class="card-value">24</div>
                <div class="card-footer">5 added this quarter</div>
            </div>

            <div class="dashboard-card">
                <div class="card-header">
                    <div class="card-title">Active Roles</div>
                    <i class="fas fa-list"></i>
                </div>
                <div class="card-value">12</div>
                <div class="card-footer">Different positions</div>
            </div>

            <div class="dashboard-card">
                <div class="card-header">
                    <div class="card-title">Training Needed</div>
                    <i class="fas fa-graduation-cap"></i>
                </div>
                <div class="card-value">3</div>
                <div class="card-footer">Officers require training</div>
            </div>
        </div>

        <!-- Officer Table -->
        <div class="officer-table-container">
            <div class="table-header">
                <div class="table-title">Church Officers</div>
                <div class="search-box">
                    <i class="fas fa-search"></i>
                    <input type="text" placeholder="Search officers...">
                </div>
                <button class="btn btn-primary" id="addOfficerBtn">
                    <i class="fas fa-plus"></i> Add Officer
                </button>
            </div>

            <table>
                <thead>
                    <tr>
                        <th>Officer</th>
                        <th>Role</th>
                        <th>Term Start</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            <div class="officer-info">
                                <div class="officer-avatar"></div>
                                <div>
                                    <div class="officer-name">Pastor John Smith</div>
                                    <div class="officer-email">john.smith@church.org</div>
                                </div>
                            </div>
                        </td>
                        <td><span class="role-tag">Senior Pastor</span></td>
                        <td>Jan 2018</td>
                        <td><span class="status-active">Active</span></td>
                        <td>
                            <button class="action-btn edit-btn">
                                <i class="fas fa-edit"></i> Edit
                            </button>
                            <button class="action-btn remove-btn">
                                <i class="fas fa-user-minus"></i>
                            </button>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="officer-info">
                                <div class="officer-avatar"></div>
                                <div>
                                    <div class="officer-name">Deacon Michael Brown</div>
                                    <div class="officer-email">michael@example.com</div>
                                </div>
                            </div>
                        </td>
                        <td><span class="role-tag">Deacon Board</span></td>
                        <td>Mar 2021</td>
                        <td><span class="status-active">Active</span></td>
                        <td>
                            <button class="action-btn edit-btn">
                                <i class="fas fa-edit"></i> Edit
                            </button>
                            <button class="action-btn remove-btn">
                                <i class="fas fa-user-minus"></i>
                            </button>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="officer-info">
                                <div class="officer-avatar"></div>
                                <div>
                                    <div class="officer-name">Sarah Johnson</div>
                                    <div class="officer-email">sarah@example.com</div>
                                </div>
                            </div>
                        </td>
                        <td><span class="role-tag">Worship Leader</span></td>
                        <td>Jun 2022</td>
                        <td><span class="status-active">Active</span></td>
                        <td>
                            <button class="action-btn edit-btn">
                                <i class="fas fa-edit"></i> Edit
                            </button>
                            <button class="action-btn remove-btn">
                                <i class="fas fa-user-minus"></i>
                            </button>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="officer-info">
                                <div class="officer-avatar"></div>
                                <div>
                                    <div class="officer-name">Robert Wilson</div>
                                    <div class="officer-email">robert@example.com</div>
                                </div>
                            </div>
                        </td>
                        <td><span class="role-tag">Treasurer</span></td>
                        <td>Jan 2020</td>
                        <td><span class="status-active">Active</span></td>
                        <td>
                            <button class="action-btn edit-btn">
                                <i class="fas fa-edit"></i> Edit
                            </button>
                            <button class="action-btn remove-btn">
                                <i class="fas fa-user-minus"></i>
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    </div>

    <!-- Add Officer Modal -->
    <div class="modal" id="addOfficerModal">
        <div class="modal-content">
            <div class="modal-header">
                <div class="modal-title">Add New Officer</div>
                <button class="close-modal" id="closeModal">&times;</button>
            </div>

            <form id="officerForm">
                <div class="form-group">
                    <label for="officerName">Full Name</label>
                    <input type="text" id="officerName" placeholder="Enter officer's full name" required>
                </div>

                <div class="form-group">
                    <label for="officerEmail">Email</label>
                    <input type="email" id="officerEmail" placeholder="Enter email address" required>
                </div>

                <div class="form-group">
                    <label for="officerRole">Role</label>
                    <select id="officerRole" required>
                        <option value="">Select a role...</option>
                        <option value="pastor">Pastor</option>
                        <option value="deacon">Deacon</option>
                        <option value="elder">Elder</option>
                        <option value="treasurer">Treasurer</option>
                        <option value="secretary">Secretary</option>
                        <option value="worship">Worship Leader</option>
                        <option value="youth">Youth Pastor</option>
                        <option value="other">Other</option>
                    </select>
                </div>

                <div class="form-group" id="customRoleGroup" style="display: none;">
                    <label for="customRole">Custom Role Name</label>
                    <input type="text" id="customRole" placeholder="Specify role">
                </div>

                <div class="form-group">
                    <label for="termStart">Term Start Date</label>
                    <input type="date" id="termStart" required>
                </div>

                <div class="form-group">
                    <label for="termEnd">Term End Date (optional)</label>
                    <input type="date" id="termEnd">
                </div>

                <div class="form-actions">
                    <button type="button" class="btn btn-outline" id="cancelAddOfficer">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save Officer</button>
                </div>
            </form>
        </div>
    </div>

@endsection
<script>
    // Modal Handling
    const addOfficerBtn = document.getElementById('addOfficerBtn');
    const addOfficerModal = document.getElementById('addOfficerModal');
    const closeModal = document.getElementById('closeModal');
    const cancelBtn = document.getElementById('cancelAddOfficer');

    addOfficerBtn.addEventListener('click', () => {
        addOfficerModal.style.display = 'flex';
    });

    closeModal.addEventListener('click', () => {
        addOfficerModal.style.display = 'none';
    });

    cancelBtn.addEventListener('click', () => {
        addOfficerModal.style.display = 'none';
    });

    // Show custom role field when "Other" is selected
    document.getElementById('officerRole').addEventListener('change', function () {
        const customRoleGroup = document.getElementById('customRoleGroup');
        customRoleGroup.style.display = this.value === 'other' ? 'block' : 'none';
    });

    // Form Submission
    document.getElementById('officerForm').addEventListener('submit', function (e) {
        e.preventDefault();

        // Get form values
        const name = document.getElementById('officerName').value;
        const email = document.getElementById('officerEmail').value;
        const role = document.getElementById('officerRole').value;
        const customRole = document.getElementById('customRole').value;
        const termStart = document.getElementById('termStart').value;
        const termEnd = document.getElementById('termEnd').value;

        // In a real app, this would send data to your backend
        console.log('Adding officer:', {
            name,
            email,
            role: role === 'other' ? customRole : role,
            termStart,
            termEnd
        });

        alert(`Officer ${name} added successfully!`);
        addOfficerModal.style.display = 'none';
        this.reset();
    });

    // Edit buttons
    document.querySelectorAll('.edit-btn').forEach(btn => {
        btn.addEventListener('click', function () {
            const officerName = this.closest('tr').querySelector('.officer-name').textContent;
            alert(`Editing ${officerName}'s details`);
            // In a real app, this would open an edit modal with pre-filled data
        });
    });

    // Remove buttons
    document.querySelectorAll('.remove-btn').forEach(btn => {
        btn.addEventListener('click', function () {
            const officerName = this.closest('tr').querySelector('.officer-name').textContent;
            if (confirm(`Are you sure you want to remove ${officerName} as an officer?`)) {
                alert(`${officerName} has been removed from officer position.`);
                // In a real app, this would make an API call to update the database
            }
        });
    });
</script>