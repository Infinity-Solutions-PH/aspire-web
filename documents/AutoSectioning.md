Phase 1: UI / UX Flow (The Modal)
1. Triggering the Process

Action: The user navigates to the Section Management module.

Action: The user clicks the "Run Auto Sectioning" button.

Result: The Auto-Sectioning Modal opens.

2. Modal Configuration & Display
The modal is divided into three primary tabs. When a user clicks a tab and makes a selection, the system queries and displays the Initial Data (the count of currently unsectioned students for that specific parameter).

Tab 1: High School Sections (Grades 7 - 10)

Input: Dropdown to select the specific Grade Level.

Display: "Unsectioned Students for Grade [X]: [Count] (Male: [Count], Female: [Count])"

Tab 2: Tech Voc Sections (Grades 8 - 10)

Input: Dropdown to select the specific Grade Level and/or Tech Voc Course.

Display: "Unsectioned Students for [Course]: [Count]"

Tab 3: Senior High School Sections (Grades 11 - 12)

Input: Dropdown to select the specific Grade Level and Strand (e.g., Grade 11 - STEM).

Display: "Unsectioned Students for [Strand]: [Count] (Male: [Count], Female: [Count])"

3. Execution

Action: The user clicks "Proceed" or "Run Sectioning" at the bottom of the modal.

Phase 2: Auto-Sectioning Logic (The Algorithm)
Once the user executes the run, the system applies the following logic based on the selected tab:

A. High School (JHS) & Senior High School (SHS) Logic
(Since SHS shares the exact same logic as JHS, they utilize the same algorithm but are filtered by Strand instead of just Grade Level).

Step 1: Star Section Allocation

Filter: Identify all unsectioned students in the selected Grade/Strand.

Qualify: Filter out students who have a general average of 90 and above.

Sort: Rank these qualified students from highest grade to lowest grade.

Assign: Fill the designated "Star Section(s)" first.

Condition: Stop assigning to the Star Section once its maximum slot capacity is reached. Any remaining students with a grade of 90+ who didn't fit into the Star Section will be pushed to the regular sectioning pool.

Step 2: Regular Section Allocation (Round-Robin & Gender Balancing)

Pool Remaining Students: Take all unsectioned students (including overflow from Step 1).

Split by Gender: Divide the pool into two separate lists: Male_Pool and Female_Pool.

Round-Robin Assignment:

Iterate through the available Regular Sections one by one (e.g., Section A, Section B, Section C).

Pop 1 Male from the Male_Pool and assign to Section A.

Pop 1 Female from the Female_Pool and assign to Section A.

Move to Section B: Assign 1 Male, 1 Female.

Move to Section C: Assign 1 Male, 1 Female.

Loop back to Section A and repeat until both gender pools are completely empty.

B. Tech Voc Sections Logic
(Tech Voc relies heavily on student preference and merit rather than purely balancing demographics).

Step 1: Preparation & Sorting

Filter: Identify all unsectioned students for the target Grade/Tech Voc pool.

Sort by Merit: Rank all students based on their General Average, from highest to lowest. (This ensures students with higher grades get priority for their first choices).

Step 2: Choice-Based Assignment Waterfall

Iterate: Loop through the sorted list of students one by one (starting with the highest-graded student).

Evaluate 1st Choice:

Check the student's 1st choice course.

If there are available slots: Assign the student. Move to the next student.

If full: Proceed to 2nd choice.

Evaluate 2nd Choice:

Check the student's 2nd choice course.

If there are available slots: Assign the student. Move to the next student.

If full: Proceed to 3rd choice.

Evaluate 3rd Choice:

Check the student's 3rd choice course.

If there are available slots: Assign the student. Move to the next student.

If full: Flag the student as "Unassigned - Manual Review Required."

Phase 3: Post-Processing
Review Screen: Once the algorithm finishes, the modal closes, and the UI redirects to a "Draft Sections" or "Preview" page.

Save/Commit: The user can review the generated lists, make minor manual tweaks if necessary, and click "Commit Sections" to finalize the data in the ASPIRE database.