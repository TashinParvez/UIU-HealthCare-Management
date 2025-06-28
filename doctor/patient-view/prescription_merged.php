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

</head>

<body>
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
        --bs-modal-bg: rgba(0, 0, 0, 0.5);
        /* Fixed transparent backdrop */
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

    .modal-footer {
        border-top: none;
        padding: 0 24px 24px;
        display: flex;
        justify-content: space-between;
    }

    .modal-footer .btn-back {
        background-color: #6c757d;
        color: white;
        border: none;
        border-radius: 25px;
        padding: 10px 40px;
        font-size: 1rem;
        font-weight: 500;
        transition: background-color 0.3s ease, transform 0.2s ease;
    }

    .modal-footer .btn-back:hover {
        background-color: #5a6268;
        transform: translateY(-2px);
    }
    </style>
    <div class="d-flex min-vh-100">
        <!-- Sidebar Placeholder (Assuming Sidebar.php exists) -->
        <div class="sidebar">
            <?php
            // Check if Sidebar.php exists to avoid errors
            if (file_exists('../../Includes/Sidebar.php')) {
                include '../../Includes/Sidebar.php';
            } else {
                echo '<div class="alert alert-warning">Sidebar.php not found.</div>';
            }
            ?>
        </div>

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
                                    <div class="line"></div>
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
                                <div class="complaint-tags" id="complaintTags">
                                    <span class="badge" data-value="Headache">Headache <i
                                            class="bi bi-x remove-tag"></i></span>
                                    <span class="badge" data-value="Insomnia">Insomnia <i
                                            class="bi bi-x remove-tag"></i></span>
                                    <span class="badge" data-value="Tiredness">Tiredness <i
                                            class="bi bi-x remove-tag"></i></span>
                                    <span class="badge" data-value="Another Complaint">Another Complaint <i
                                            class="bi bi-x remove-tag"></i></span>
                                    <span class="badge" data-value="Typhoid">Typhoid <i
                                            class="bi bi-x remove-tag"></i></span>
                                </div>
                                <textarea id="complaintNotes" placeholder="Enter additional chief complaints"
                                    aria-label="Chief Complaints Notes"></textarea>
                                <button class="btn-submit"
                                    onclick="saveAndContinue('complaintsModal', 'medicineModal')">Continue</button>
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
                                    <div class="line"></div>
                                    <div class="step">3</div>
                                    <div class="line"></div>
                                    <div class="step">4</div>
                                    <div class="line"></div>
                                    <div class="step">5</div>
                                    <div class="line"></div>
                                    <div class="step">6</div>
                                </div>
                                <h5>Medicine</h5>
                                <div id="medicineRows">
                                    <div class="medicine-row">
                                        <input type="text" placeholder="Medicine Name" aria-label="Medicine Name">
                                        <input type="number" min="1" value="1" aria-label="Dosage">
                                        <select aria-label="Meal Timing">
                                            <option>Before Meal</option>
                                            <option>After Meal</option>
                                        </select>
                                        <input type="text" value="10 Days" aria-label="Duration">
                                    </div>
                                </div>
                                <div class="add-more">
                                    <a href="#" onclick="addMedicineRow()">Add More <i
                                            class="bi bi-plus-circle me-1"></i></a>
                                </div>
                                <button class="btn-submit"
                                    onclick="saveAndContinue('medicineModal', 'testsModal')">Continue</button>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button class="btn-back" onclick="goBack('medicineModal', 'complaintsModal')">Back</button>
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
                                    <div class="line"></div>
                                    <div class="step">4</div>
                                    <div class="line"></div>
                                    <div class="step">5</div>
                                    <div class="line"></div>
                                    <div class="step">6</div>
                                </div>
                                <h5>Diagnosis</h5>
                                <div class="test-tags" id="testTags">
                                    <span class="badge" data-value="X Ray">X Ray <i
                                            class="bi bi-x remove-tag"></i></span>
                                    <span class="badge" data-value="ECG">ECG <i class="bi bi-x remove-tag"></i></span>
                                    <span class="badge" data-value="Cholesterol">Cholesterol <i
                                            class="bi bi-x remove-tag"></i></span>
                                    <span class="badge" data-value="RCB">RCB <i class="bi bi-x remove-tag"></i></span>
                                    <span class="badge" data-value="Typhoid">Typhoid <i
                                            class="bi bi-x remove-tag"></i></span>
                                </div>
                                <textarea id="testNotes" placeholder="Enter additional diagnosis notes"
                                    aria-label="Diagnosis Notes"></textarea>
                                <button class="btn-submit"
                                    onclick="saveAndContinue('testsModal', 'adviceModal')">Continue</button>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button class="btn-back" onclick="goBack('testsModal', 'medicineModal')">Back</button>
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
                                    <div class="step active">3</div>
                                    <div class="line active"></div>
                                    <div class="step active">4</div>
                                    <div class="line"></div>
                                    <div class="step">5</div>
                                    <div class="line"></div>
                                    <div class="step">6</div>
                                </div>
                                <h5>Advice</h5>
                                <textarea id="adviceNotes" placeholder="Enter advice for the patient"
                                    aria-label="Advice Notes"></textarea>
                                <button class="btn-submit"
                                    onclick="saveAndContinue('adviceModal', 'specialistModal')">Continue</button>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button class="btn-back" onclick="goBack('adviceModal', 'testsModal')">Back</button>
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
                                    <div class="line"></div>
                                    <div class="step">6</div>
                                </div>
                                <h5>Refer to Specialist</h5>
                                <div class="specialist-tags" id="specialistTags">
                                    <span class="badge" data-value="Neurologist">Neurologist <i
                                            class="bi bi-x remove-tag"></i></span>
                                    <span class="badge" data-value="Cardiologist">Cardiologist <i
                                            class="bi bi-x remove-tag"></i></span>
                                    <span class="badge" data-value="Oncologist">Oncologist <i
                                            class="bi bi-x remove-tag"></i></span>
                                    <span class="badge" data-value="Orthopedic Surgeon">Orthopedic Surgeon <i
                                            class="bi bi-x remove-tag"></i></span>
                                </div>
                                <textarea id="specialistNotes" placeholder="Enter referral notes"
                                    aria-label="Referral Notes"></textarea>
                                <button class="btn-submit"
                                    onclick="saveAndContinue('specialistModal', 'followupModal')">Continue</button>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button class="btn-back" onclick="goBack('specialistModal', 'adviceModal')">Back</button>
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
                                    <input type="date" id="followupDate" value="2025-04-26" aria-label="Follow-Up Date">
                                    <input type="time" id="followupTime" value="09:00" aria-label="Follow-Up Time">
                                </div>
                                <textarea id="followupNotes" placeholder="Enter follow-up notes"
                                    aria-label="Follow-Up Notes"></textarea>
                                <button class="btn-submit" onclick="submitPrescription()">Submit</button>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button class="btn-back" onclick="goBack('followupModal', 'specialistModal')">Back</button>
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
    // Store prescription data
    let prescriptionData = {
        complaints: {
            tags: [],
            notes: ''
        },
        medicines: [],
        tests: {
            tags: [],
            notes: ''
        },
        advice: '',
        specialists: {
            tags: [],
            notes: ''
        },
        followup: {
            date: '',
            time: '',
            notes: ''
        }
    };

    // Initialize tag removal listeners
    document.addEventListener('DOMContentLoaded', () => {
        ['complaintTags', 'testTags', 'specialistTags'].forEach(tagContainerId => {
            const container = document.getElementById(tagContainerId);
            if (container) {
                container.addEventListener('click', (e) => {
                    if (e.target.classList.contains('remove-tag')) {
                        const tag = e.target.parentElement;
                        const value = tag.dataset.value;
                        tag.remove();
                        updateTags(tagContainerId, value);
                    }
                });
            }
        });
    });

    // Update tags in prescriptionData
    function updateTags(containerId, removedValue) {
        if (containerId === 'complaintTags') {
            prescriptionData.complaints.tags = prescriptionData.complaints.tags.filter(tag => tag !== removedValue);
        } else if (containerId === 'testTags') {
            prescriptionData.tests.tags = prescriptionData.tests.tags.filter(tag => tag !== removedValue);
        } else if (containerId === 'specialistTags') {
            prescriptionData.specialists.tags = prescriptionData.specialists.tags.filter(tag => tag !== removedValue);
        }
    }

    // Add new medicine row
    function addMedicineRow() {
        const medicineRows = document.getElementById('medicineRows');
        const newRow = document.createElement('div');
        newRow.className = 'medicine-row';
        newRow.innerHTML = `
                <input type="text" placeholder="Medicine Name" aria-label="Medicine Name">
                <input type="number" min="1" value="1" aria-label="Dosage">
                <select aria-label="Meal Timing">
                    <option>Before Meal</option>
                    <option>After Meal</option>
                </select>
                <input type="text" value="10 Days" aria-label="Duration">
            `;
        medicineRows.appendChild(newRow);
    }

    // Save data and continue to next modal
    function saveAndContinue(currentModalId, nextModalId) {
        // Validate and save data based on current modal
        if (currentModalId === 'complaintsModal') {
            const tags = Array.from(document.querySelectorAll('#complaintTags .badge')).map(tag => tag.dataset.value);
            const notes = document.getElementById('complaintNotes').value.trim();
            if (tags.length === 0 && !notes) {
                alert('Please add at least one complaint or note.');
                return;
            }
            prescriptionData.complaints.tags = tags;
            prescriptionData.complaints.notes = notes;
        } else if (currentModalId === 'medicineModal') {
            const rows = document.querySelectorAll('#medicineRows .medicine-row');
            const medicines = Array.from(rows).map(row => ({
                name: row.children[0].value.trim(),
                dosage: row.children[1].value,
                timing: row.children[2].value,
                duration: row.children[3].value.trim()
            }));
            if (medicines.every(med => !med.name)) {
                alert('Please add at least one medicine.');
                return;
            }
            prescriptionData.medicines = medicines.filter(med => med.name);
        } else if (currentModalId === 'testsModal') {
            const tags = Array.from(document.querySelectorAll('#testTags .badge')).map(tag => tag.dataset.value);
            const notes = document.getElementById('testNotes').value.trim();
            prescriptionData.tests.tags = tags;
            prescriptionData.tests.notes = notes;
        } else if (currentModalId === 'adviceModal') {
            const advice = document.getElementById('adviceNotes').value.trim();
            prescriptionData.advice = advice;
        } else if (currentModalId === 'specialistModal') {
            const tags = Array.from(document.querySelectorAll('#specialistTags .badge')).map(tag => tag.dataset.value);
            const notes = document.getElementById('specialistNotes').value.trim();
            prescriptionData.specialists.tags = tags;
            prescriptionData.specialists.notes = notes;
        }

        // Open next modal
        const currentModal = bootstrap.Modal.getInstance(document.getElementById(currentModalId));
        currentModal.hide();
        const nextModal = new bootstrap.Modal(document.getElementById(nextModalId), {
            backdrop: 'static',
            keyboard: false
        });
        nextModal.show();
    }

    // Go back to previous modal
    function goBack(currentModalId, previousModalId) {
        const currentModal = bootstrap.Modal.getInstance(document.getElementById(currentModalId));
        currentModal.hide();
        const previousModal = new bootstrap.Modal(document.getElementById(previousModalId), {
            backdrop: 'static',
            keyboard: false
        });
        previousModal.show();
    }

    // Submit prescription
    function submitPrescription() {
        const date = document.getElementById('followupDate').value;
        const time = document.getElementById('followupTime').value;
        const notes = document.getElementById('followupNotes').value.trim();

        if (!date || !time) {
            alert('Please specify follow-up date and time.');
            return;
        }

        prescriptionData.followup = {
            date,
            time,
            notes
        };

        // Log data to console (replace with actual backend submission)
        console.log('Prescription Data:', prescriptionData);

        // Example: Send to backend (uncomment and configure as needed)
        /*
        fetch('/api/prescription', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(prescriptionData)
        })
        .then(response => response.json())
        .then(data => {
            alert('Prescription submitted successfully!');
            resetForm();
        })
        .catch(error => alert('Error submitting prescription: ' + error));
        */

        // For demo, show alert and reset
        alert('Prescription submitted successfully!');
        resetForm();

        const modal = bootstrap.Modal.getInstance(document.getElementById('followupModal'));
        modal.hide();
    }

    // Reset form data and UI
    function resetForm() {
        prescriptionData = {
            complaints: {
                tags: [],
                notes: ''
            },
            medicines: [],
            tests: {
                tags: [],
                notes: ''
            },
            advice: '',
            specialists: {
                tags: [],
                notes: ''
            },
            followup: {
                date: '',
                time: '',
                notes: ''
            }
        };

        // Reset Complaints Modal
        document.getElementById('complaintNotes').value = '';
        const complaintTags = document.getElementById('complaintTags');
        complaintTags.innerHTML = `
                <span class="badge" data-value="Headache">Headache <i class="bi bi-x remove-tag"></i></span>
                <span class="badge" data-value="Insomnia">Insomnia <i class="bi bi-x remove-tag"></i></span>
                <span class="badge" data-value="Tiredness">Tiredness <i class="bi bi-x remove-tag"></i></span>
                <span class="badge" data-value="Another Complaint">Another Complaint <i class="bi bi-x remove-tag"></i></span>
                <span class="badge" data-value="Typhoid">Typhoid <i class="bi bi-x remove-tag"></i></span>
            `;

        // Reset Medicine Modal
        const medicineRows = document.getElementById('medicineRows');
        medicineRows.innerHTML = `
                <div class="medicine-row">
                    <input type="text" placeholder="Medicine Name" aria-label="Medicine Name">
                    <input type="number" min="1" value="1" aria-label="Dosage">
                    <select aria-label="Meal Timing">
                        <option>Before Meal</option>
                        <option>After Meal</option>
                    </select>
                    <input type="text" value="10 Days" aria-label="Duration">
                </div>
            `;

        // Reset Tests Modal
        document.getElementById('testNotes').value = '';
        const testTags = document.getElementById('testTags');
        testTags.innerHTML = `
                <span class="badge" data-value="X Ray">X Ray <i class="bi bi-x remove-tag"></i></span>
                <span class="badge" data-value="ECG">ECG <i class="bi bi-x remove-tag"></i></span>
                <span class="badge" data-value="Cholesterol">Cholesterol <i class="bi bi-x remove-tag"></i></span>
                <span class="badge" data-value="RCB">RCB <i class="bi bi-x remove-tag"></i></span>
                <span class="badge" data-value="Typhoid">Typhoid <i class="bi bi-x remove-tag"></i></span>
            `;

        // Reset Advice Modal
        document.getElementById('adviceNotes').value = '';

        // Reset Specialist Modal
        document.getElementById('specialistNotes').value = '';
        const specialistTags = document.getElementById('specialistTags');
        specialistTags.innerHTML = `
                <span class="badge" data-value="Neurologist">Neurologist <i class="bi bi-x remove-tag"></i></span>
                <span class="badge" data-value="Cardiologist">Cardiologist <i class="bi bi-x remove-tag"></i></span>
                <span class="badge" data-value="Oncologist">Oncologist <i class="bi bi-x remove-tag"></i></span>
                <span class="badge" data-value="Orthopedic Surgeon">Orthopedic Surgeon <i class="bi bi-x remove-tag"></i></span>
            `;

        // Reset Follow-Up Modal
        document.getElementById('followupDate').value = '2025-04-26';
        document.getElementById('followupTime').value = '09:00';
        document.getElementById('followupNotes').value = '';
    }
    </script>
</body>

</html>