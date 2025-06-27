<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Prescription Dashboard</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Custom CSS -->
    <style>
    body {
        background-color: #f4f6f9;
        margin: 0;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    .content {
        margin-left: 64px;
        padding: 0;
        transition: margin-left 0.4s ease-in-out;
        width: calc(100% - 64px);
        min-height: 100vh;
        display: flex;
        justify-content: center;
        align-items: center;
        flex-direction: column;
    }

    .sidebar:hover+.content {
        margin-left: 256px;
        width: calc(100% - 256px);
    }

    .sidebar {
        transition: width 0.4s ease-in-out;
        transform: translateZ(0);
        will-change: width;
    }

    .sidebar:not(:hover) .sidebar-text,
    .sidebar:not(:hover) .search-input {
        display: none;
    }

    .sidebar-item {
        position: relative;
        overflow: hidden;
        transition: background-color 0.3s ease, transform 0.2s ease;
    }

    .sidebar-item:hover {
        background-color: #e9ecef;
        transform: translateX(5px);
    }

    .dashboard-section {
        width: 100%;
        max-width: 800px;
        text-align: center;
    }

    .dashboard-section h2 {
        font-size: 1.8rem;
        font-weight: 600;
        color: #1a3c34;
        margin-bottom: 30px;
    }

    .btn-prescription {
        background-color: #007bff;
        color: white;
        border: none;
        border-radius: 25px;
        padding: 12px 40px;
        font-size: 1rem;
        font-weight: 500;
        margin: 10px;
        transition: background-color 0.3s ease, transform 0.2s ease, box-shadow 0.3s ease;
    }

    .btn-prescription:hover {
        background-color: #0056b3;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 123, 255, 0.3);
    }

    .modal {
        --bs-modal-bg: transparent;
    }

    .modal-dialog {
        max-width: 700px;
        margin: 1.75rem auto;
        transition: transform 0.3s ease-out, opacity 0.2s ease-out;
    }

    .modal.fade .modal-dialog {
        transform: translateY(-50px);
        opacity: 0;
    }

    .modal.show .modal-dialog {
        transform: translateY(0);
        opacity: 1;
    }

    .modal-content {
        border: none;
        border-radius: 12px;
        background: white;
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.15);
        overflow: hidden;
    }

    .modal-header {
        border-bottom: none;
        padding: 20px 24px;
    }

    .modal-header .btn-close {
        background-size: 1.2rem;
        opacity: 0.7;
        transition: opacity 0.2s ease;
    }

    .modal-header .btn-close:hover {
        opacity: 1;
    }

    .modal-body {
        padding: 24px;
    }

    .modal-body .card {
        border: none;
        box-shadow: none;
        background: transparent;
    }

    .modal-body .step-indicator {
        display: flex;
        justify-content: center;
        margin-bottom: 20px;
    }

    .modal-body .step-indicator .step {
        width: 28px;
        height: 28px;
        border-radius: 50%;
        background-color: #e9ecef;
        color: #6c757d;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 6px;
        font-size: 0.85rem;
        font-weight: 500;
        transition: background-color 0.3s ease, transform 0.2s ease;
    }

    .modal-body .step-indicator .step.active {
        background-color: #007bff;
        color: white;
        transform: scale(1.1);
    }

    .modal-body .step-indicator .line {
        width: 36px;
        height: 3px;
        background-color: #e9ecef;
        margin: 12.5px 0;
        transition: background-color 0.3s ease;
    }

    .modal-body .step-indicator .line.active {
        background-color: #007bff;
    }

    .modal-body .card h5 {
        font-size: 1.5rem;
        font-weight: 600;
        color: #1a3c34;
        text-align: center;
        margin-bottom: 24px;
    }

    .modal-body .complaint-tags .badge,
    .modal-body .test-tags .badge,
    .modal-body .specialist-tags .badge {
        background-color: #6c757d;
        color: white;
        font-size: 0.85rem;
        padding: 8px 14px;
        margin: 4px;
        border-radius: 16px;
        cursor: pointer;
        transition: background-color 0.2s ease, transform 0.2s ease;
    }

    .modal-body .complaint-tags .badge:hover,
    .modal-body .test-tags .badge:hover,
    .modal-body .specialist-tags .badge:hover {
        background-color: #5a6268;
        transform: translateY(-1px);
    }

    .modal-body .complaint-tags .badge i,
    .modal-body .test-tags .badge i,
    .modal-body .specialist-tags .badge i {
        margin-left: 6px;
    }

    .modal-body textarea {
        width: 100%;
        min-height: 140px;
        border: 1px solid #dee2e6;
        border-radius: 8px;
        padding: 12px;
        font-size: 0.9rem;
        color: #495057;
        transition: border-color 0.2s ease, box-shadow 0.2s ease;
    }

    .modal-body textarea:focus {
        border-color: #007bff;
        box-shadow: 0 0 0 3px rgba(0, 123, 255, 0.1);
        outline: none;
    }

    .modal-body .medicine-row,
    .modal-body .followup-row {
        display: flex;
        align-items: center;
        margin-bottom: 12px;
        gap: 8px;
    }

    .modal-body .medicine-row input[type="text"],
    .modal-body .medicine-row input[type="number"],
    .modal-body .medicine-row select,
    .modal-body .followup-row input[type="date"],
    .modal-body .followup-row input[type="time"] {
        border: 1px solid #dee2e6;
        border-radius: 8px;
        padding: 8px 12px;
        font-size: 0.9rem;
        color: #495057;
        transition: border-color 0.2s ease, box-shadow 0.2s ease;
    }

    .modal-body .medicine-row input[type="text"] {
        flex: 2;
    }

    .modal-body .medicine-row input[type="number"] {
        width: 60px;
    }

    .modal-body .medicine-row select,
    .modal-body .followup-row input[type="date"],
    .modal-body .followup-row input[type="time"] {
        flex: 1;
    }

    .modal-body .medicine-row input:focus,
    .modal-body .medicine-row select:focus,
    .modal-body .followup-row input:focus {
        border-color: #007bff;
        box-shadow: 0 0 0 3px rgba(0, 123, 255, 0.1);
        outline: none;
    }

    .modal-body .add-more {
        text-align: center;
        margin-bottom: 20px;
    }

    .modal-body .add-more a {
        color: #6c757d;
        text-decoration: none;
        font-size: 0.85rem;
        font-weight: 500;
        transition: color 0.2s ease;
    }

    .modal-body .add-more a:hover {
        color: #007bff;
    }

    .modal-body .btn-submit {
        background-color: #007bff;
        color: white;
        border: none;
        border-radius: 25px;
        padding: 10px 40px;
        font-size: 1rem;
        font-weight: 500;
        display: block;
        margin: 20px auto 0;
        transition: background-color 0.3s ease, transform 0.2s ease, box-shadow 0.3s ease;
    }

    .modal-body .btn-submit:hover {
        background-color: #0056b3;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 123, 255, 0.3);
    }
    </style>
</head>

<body>
    <div class="d-flex min-vh-100">
        <!-- Include Sidebar -->
        <?php include '../../Includes/Sidebar.php'; ?>

        <!-- Main Content -->
        <div class="content">
            <div class="dashboard-section">
                <h2>Prescription Dashboard</h2>
                <button class="btn-prescription" data-bs-toggle="modal" data-bs-target="#complaintsModal">Start
                    Prescription</button>
            </div>

            <!-- Complaints Modal -->
            <div class="modal fade" id="complaintsModal" tabindex="-1" aria-labelledby="complaintsModalLabel"
                aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="complaintsModalLabel">Chief Complaints</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="card">
                                <div class="step-indicator">
                                    <div class="step active">1</div>
                                    <div class="line active"></div>
                                    <div class="step">2</div>
                                    <div class="line"></div>
                                    <div class="step">3</div>
                                    <div class="line"></div>
                                    <div class="step">4</div>
                                    <div class="line"></div>
                                    <div class="step">5</div>
                                    <div class="line"></div>
                                    <div class="step">6</div>
                                </div>
                                <h5>Chief Complaints</h5>
                                <div class="complaint-tags">
                                    <span class="badge">Headache <i class="bi bi-x"></i></span>
                                    <span class="badge">Insomnia <i class="bi bi-x"></i></span>
                                    <span class="badge">Tiredness <i class="bi bi-x"></i></span>
                                    <span class="badge">Another Complaint <i class="bi bi-x"></i></span>
                                    <span class="badge">Typhoid <i class="bi bi-x"></i></span>
                                </div>
                                <textarea placeholder="Chief Complaints"></textarea>
                                <button class="btn-submit" data-bs-dismiss="modal"
                                    onclick="openNextModal('medicineModal')">Continue</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Medicine Modal -->
            <div class="modal fade" id="medicineModal" tabindex="-1" aria-labelledby="medicineModalLabel"
                aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="medicineModalLabel">Prescribe Medicine</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="card">
                                <div class="step-indicator">
                                    <div class="step active">1</div>
                                    <div class="line active"></div>
                                    <div class="step active">2</div>
                                    <div class="line active"></div>
                                    <div class="step">3</div>
                                    <div class="line"></div>
                                    <div class="step">4</div>
                                    <div class="line"></div>
                                    <div class="step">5</div>
                                    <div class="line"></div>
                                    <div class="step">6</div>
                                </div>
                                <h5>Medicine</h5>
                                <div class="medicine-row">
                                    <input type="text" placeholder="Medicine Name">
                                    <input type="number" value="1">
                                    <select>
                                        <option>Before Meal</option>
                                        <option>After Meal</option>
                                    </select>
                                    <input type="text" value="10 Days">
                                </div>
                                <div class="medicine-row">
                                    <input type="text" placeholder="Medicine Name">
                                    <input type="number" value="1">
                                    <select>
                                        <option>Before Meal</option>
                                        <option>After Meal</option>
                                    </select>
                                    <input type="text" value="10 Days">
                                </div>
                                <div class="medicine-row">
                                    <input type="text" placeholder="Medicine Name">
                                    <input type="number" value="1">
                                    <select>
                                        <option>Before Meal</option>
                                        <option>After Meal</option>
                                    </select>
                                    <input type="text" value="10 Days">
                                </div>
                                <div class="medicine-row">
                                    <input type="text" placeholder="Medicine Name">
                                    <input type="number" value="1">
                                    <select>
                                        <option>Before Meal</option>
                                        <option>After Meal</option>
                                    </select>
                                    <input type="text" value="10 Days">
                                </div>
                                <div class="add-more">
                                    <a href="#"><i class="bi bi-plus-circle me-1"></i>Add More</a>
                                </div>
                                <button class="btn-submit" data-bs-dismiss="modal"
                                    onclick="openNextModal('testsModal')">Continue</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tests Modal -->
            <div class="modal fade" id="testsModal" tabindex="-1" aria-labelledby="testsModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="testsModalLabel">Order Tests</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="card">
                                <div class="step-indicator">
                                    <div class="step active">1</div>
                                    <div class="line active"></div>
                                    <div class="step active">2</div>
                                    <div class="line active"></div>
                                    <div class="step active">3</div>
                                    <div class="line active"></div>
                                    <div class="step">4</div>
                                    <div class="line"></div>
                                    <div class="step">5</div>
                                    <div class="line"></div>
                                    <div class="step">6</div>
                                </div>
                                <h5>Diagnosis</h5>
                                <div class="test-tags">
                                    <span class="badge">X Ray <i class="bi bi-x"></i></span>
                                    <span class="badge">ECG <i class="bi bi-x"></iAt></span>
                                    <span class="badge">Cholesterol <i class="bi bi-x"></i></span>
                                    <span class="badge">RCB <i class="bi bi-x"></i></span>
                                    <span class="badge">Another Complain <i class="bi bi-x"></i></span>
                                    <span class="badge">Typhoid <i class="bi bi-x"></i></span>
                                </div>
                                <textarea placeholder="Diagnosis"></textarea>
                                <button class="btn-submit" data-bs-dismiss="modal"
                                    onclick="openNextModal('adviceModal')">Continue</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Advice Modal -->
            <div class="modal fade" id="adviceModal" tabindex="-1" aria-labelledby="adviceModalLabel"
                aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="adviceModalLabel">Give Advice</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="card">
                                <div class="step-indicator">
                                    <div class="step active">1</div>
                                    <div class="line active"></div>
                                    <div class="step active">2</div>
                                    <div class="line active"></div>
                                    <div class="step6 active">3</div>
                                    <div class="line active"></div>
                                    <div class="step active">4</div>
                                    <div class="line active"></div>
                                    <div class="step">5</div>
                                    <div class="line"></div>
                                    <div class="step">6</div>
                                </div>
                                <h5>Advice</h5>
                                <textarea placeholder="Advice"></textarea>
                                <button class="btn-submit" data-bs-dismiss="modal"
                                    onclick="openNextModal('specialistModal')">Continue</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Specialist Modal -->
            <div class="modal fade" id="specialistModal" tabindex="-1" aria-labelledby="specialistModalLabel"
                aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="specialistModalLabel">Refer to Specialist</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="card">
                                <div class="step-indicator">
                                    <div class="step active">1</div>
                                    <div class="line active"></div>
                                    <div class="step active">2</div>
                                    <div class="line active"></div>
                                    <div class="step active">3</div>
                                    <div class="line active"></div>
                                    <div class="step active">4</div>
                                    <div class="line active"></div>
                                    <div class="step active">5</div>
                                    <div class="line active"></div>
                                    <div class="step">6</div>
                                </div>
                                <h5>Refer to Specialist</h5>
                                <div class="specialist-tags">
                                    <span class="badge">Neurologist <i class="bi bi-x"></i></span>
                                    <span class="badge">Cardiologist <i class="bi bi-x"></i></span>
                                    <span class="badge">Oncologist <i class="bi bi-x"></i></span>
                                    <span class="badge">Orthopedic Surgeon <i class="bi bi-x"></i></span>
                                </div>
                                <textarea placeholder="Referral Notes"></textarea>
                                <button class="btn-submit" data-bs-dismiss="modal"
                                    onclick="openNextModal('followupModal')">Continue</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Follow-Up Modal -->
            <div class="modal fade" id="followupModal" tabindex="-1" aria-labelledby="followupModalLabel"
                aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="followupModalLabel">Schedule Follow-Up</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="card">
                                <div class="step-indicator">
                                    <div class="step active">1</div>
                                    <div class="line active"></div>
                                    <div class="step active">2</div>
                                    <div class="line active"></div>
                                    <div class="step active">3</div>
                                    <div class="line active"></div>
                                    <div class="step active">4</div>
                                    <div class="line active"></div>
                                    <div class="step active">5</div>
                                    <div class="line active"></div>
                                    <div class="step active">6</div>
                                </div>
                                <h5>Schedule Follow-Up</h5>
                                <div class="followup-row">
                                    <input type="date" value="2025-04-26">
                                    <input type="time" value="09:00">
                                </div>
                                <textarea placeholder="Follow-Up Notes"></textarea>
                                <button class="btn-submit" data-bs-dismiss="modal">Submit</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
    <script>
    function openNextModal(modalId) {
        const nextModal = new bootstrap.Modal(document.getElementById(modalId), {
            backdrop: 'static',
            keyboard: false
        });
        nextModal.show();
    }
    </script>
</body>

</html>