ENROLLMENT PROCESS

### Phase 1: Account Creation & Pre-Registration
Before filling out the official DepEd form, the user needs a secure way to save their progress and track their application status.
Parent/Student Portal Registration: The applicant or parent creates an ASPIRE account using an email address or mobile number.
Enrollment Intent: The user selects "New Enrollment" and specifies the "Grade level to Enroll". For incoming secondary students from elementary, this will be Grade 7.

### Phase 2: The Digital Basic Education Enrollment Form
This phase digitizes the provided Annex 1 form. Using a multi-step form approach (which can be seamlessly managed by Livewire for backend state and Alpine.js for instantaneous UI toggles) prevents overwhelming the user.

## Step 1: Learner Information
Collect basic data: PSA Birth Certificate No., LRN, Name, Birthdate, and Sex.
Dynamic Toggles: Use client-side logic to reveal follow-up questions only when necessary.
If the user belongs to an Indigenous Peoples (IP) Community , reveal a text input to specify the community.
If the family is a 4Ps beneficiary , require the 4Ps Household ID Number.
If "Yes" is selected for Learner with Disability , display the specific disability checkboxes (e.g., Visual Impairment, Learning Disability, Autism Spectrum Disorder).

## Step 2: Address Information
Collect the Current Address (House No., Street, Barangay, Municipality/City, Province, Zip Code).
Provide a "Same with your Current Address?" checkbox. If unchecked, reveal the fields to input the Permanent Address.

## Step 3: Parent's/Guardian's Information
Collect names and contact numbers for the Father, Mother (Maiden Name), and Legal Guardian.

## Step 4: Academic History & Preferences
For transferring students or returning learners (Balik-Aral) , collect the Last Grade Level Completed, Last School Year Completed, Last School Attended, and School ID.
Conditional SHS Routing: If the student is enrolling in Senior High School, mandate the selection of Semester, Track, and Strand.
Conditional Tech-Voc Routing: Since Tanza National Trade School offers specialized courses for Grade 8, implement a custom selection field specifically for Grade 8 enrollees to choose their technical specialization.
Capture any distance learning modality preferences (e.g., Modular, Online, Blended).

## Step 5: Document Uploads & Data Privacy Consent
Provide secure file upload dropzones (handled safely via your backend storage architecture) for scanned documents:
PSA Birth Certificate
SF9 (Form 138 / Report Card) from the elementary school
Certificate of Good Moral Character
Require an e-signature or checkbox confirming that the information is true and consenting to the Data Privacy Act of 2012.

### Phase 3: Administrative Assessment (Backend)
Once the form is submitted, the workflow shifts to the school's administrative dashboard in ASPIRE.
Registrar Verification: The school registrar receives a notification. They review the uploaded documents against the submitted Learner Information System (LIS) data to ensure the LRN and identity match.
Academic Evaluation: * For Grade 7: Verify elementary completion via the uploaded SF9.
For Grade 8: The department head reviews the student's eligibility for their chosen Tech-Voc specialized course.
For SHS: Verify prerequisite completion for the chosen Track and Strand.
Deficiency Handling: If a document is blurred or missing, the registrar changes the application status to "Pending Revision," which triggers an automated email/SMS back to the parent detailing what needs to be fixed.

### Phase 4: Sectioning and Finalization
Section Assignment: Once verified, the student is pooled into a list of eligible enrollees. The system can either auto-assign them to a section based on balancing algorithms (gender, grades) or allow the registrar to manually slot them into a specific section.
Official Enrollment: The system generates a digital Certificate of Enrollment or an assessment form for any miscellaneous fees.
Confirmation: The student's status changes to "Officially Enrolled." ASPIRE automatically dispatches a welcome email with their section, adviser's name, and class schedule.