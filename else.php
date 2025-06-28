<div class="space-y-4">
    <?php foreach ($allAppointments as $index => $row) { ?>
        <div class="appointment-card bg-white rounded-xl p-6 flex items-center justify-between gap-6 border border-gray-100 cursor-pointer"
            data-id="<?php echo $row['appointment_id']; ?>"
            data-name="<?php echo htmlspecialchars($row['Name']); ?>"
            data-email="<?php echo htmlspecialchars($row['Email']); ?>"
            data-date="<?php echo $row['AppointmentDate']; ?>"
            data-time="<?php echo $row['VisitTime']; ?>">
            <div class="flex items-center gap-4">
                <img src="/Includes/Images/happy-patient.jpg" alt="<?php echo htmlspecialchars($row['Name']); ?>" class="w-12 h-12 rounded-full object-cover">
                <div>
                    <h3 class="text-lg font-medium text-gray-800"><?php echo htmlspecialchars($row['Name']); ?></h3>
                    <p class="text-sm text-gray-500"><?php echo htmlspecialchars($row['Email']); ?></p>
                </div>
            </div>
            <div class="text-sm text-gray-600"><?php echo $row['AppointmentDate']; ?></div>
            <div class="text-sm text-gray-600"><?php echo $row['VisitTime']; ?></div>
            <div class="text-sm text-gray-600">DOCTORNAME</div>
            <div class="text-sm text-gray-600">CONDITION</div>
            <div class="flex gap-4">
                <a href="#" class="action-icon text-gray-500 hover:text-blue-600"><i class="bi bi-pencil"></i></a>
                <a href="#" class="action-icon text-gray-500 hover:text-red-600"><i class="bi bi-trash"></i></a>
            </div>
        </div>
    <?php } ?>
</div>