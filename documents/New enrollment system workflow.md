# System Workflow Specification: Academic Enrollment & Student Lifecycle

This document outlines the state transitions and data flow for a technical-vocational secondary school enrollment system.

## Phase 1: New Student Admission (The Entry Point)
1. **Application Initiation:** A prospective student begins filling out the online admission form.
   * *System Action:* An admission record is created with the status set to `draft`.
2. **Application Submission:** The student completes all required fields and submits the form.
   * *System Action:* The admission record status changes to `pending_review`.
3. **Registrar Evaluation & Approval:** The registrar reviews the application via the admin dashboard. Upon approval:
   * *Data Preservation:* The admission record is **not hard-deleted**. Instead, it is soft-deleted (or status changed to `processed`/`archived`) to preserve the historical audit trail.
   * *Entity Creation:* The system generates three foundational records:
       * A `user` record (for student portal authentication).
       * A `student` record (core identity, `global_status` = `active`).
       * An `enrollment` record linked to the current active school year (`term_status` = `enrolled`).

## Phase 2: Sectioning & Active Enrollment
4. **Auto-Sectioning & Tech-Voc Assignment:** The system assigns students to sections based on capacity and their preferred technical-vocational choices.
   * *System Action:* The system cascades through the student's 1st, 2nd, and 3rd choices. 
   * *Technical Constraint:* This entire assignment block must be wrapped in a **Database Transaction** (e.g., `DB::transaction()`) with pessimistic locking to prevent race conditions and over-enrolling a section beyond its hard cap.
5. **Active School Year:** Students attend classes, and faculty encode grades into the system.

## Phase 3: End of School Year Processing (Batch Evaluation)
6. **Term Closure & Automated Grading:** The admin triggers the "Close School Year" function. The system runs a batch evaluation of all active enrollments against a strict block-retention policy.
   * *Condition A (Passed):* If the student passes ALL subjects, their `academic_result` is set to `passed`, and their `term_status` becomes `completed`.
   * *Condition B (Failed):* If the student fails **one or more** subjects, they fail the entire block. Their `academic_result` is set to `failed`, and `term_status` becomes `completed`.
   * *Condition C (Graduating):* If the student passes all subjects and is in a terminal grade (Grade 10 or Grade 12), their `academic_result` is set to `graduated`, and `term_status` becomes `completed`.
7. **System Reset:** The current Academic Year is marked inactive. The admin creates a new Academic Year and sets it to `active`.

## Phase 4: Returning Student Enrollment (The Portal Loop)
8. **Portal Self-Enrollment:** Existing students log into their portal to enroll for the new active academic year. This bypasses the admission table entirely. The UI adapts based on their latest `academic_result`:
   * *Scenario A (Promoted):* The previous result was `passed`. The portal offers enrollment for the next sequential grade level. The student confirms and selects their new tech-voc choices.
   * *Scenario B (Retained):* The previous result was `failed`. The portal forces the student to re-enroll in the exact same grade level they just failed. They cannot pick new tech-voc courses.
   * *Scenario C (JHS to SHS Promotion):* The previous result was `graduated` (from Grade 10). The portal promotes them to Senior High School (Grade 11) and presents the UI to select their SHS Strand.
9. **Enrollment Confirmation:** Upon student confirmation, a **new** record is created in the `enrollments` table for the current school year with an `approved` status.
10. **Return to Phase 2:** The system routes the new enrollment record back to Step 4 for auto-sectioning.

## Phase 5: Handling Alumni (State Management)
11. **Alumni Tagging:** When a student successfully finishes a terminal program (Grade 10 or Grade 12), the system updates their core `students` table record rather than migrating them to a disconnected database table.
    * *System Action:* If graduating Grade 10, toggle the boolean `is_jhs_alumni = true`. 
    * *System Action:* If graduating Grade 12, toggle the boolean `is_shs_alumni = true` and update their `global_status` from `active` to `alumni`.
12. **Unified Account:** The student retains the exact same `users` account and portal access from Grade 7 through post-graduation. The portal interface simply reads the boolean flags and the latest `enrollments` record to determine what dashboard to display.
