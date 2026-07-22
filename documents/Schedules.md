Act as an expert Database Architect. Please write the complete SQL schema (in [INSERT YOUR PREFERRED SQL DIALECT HERE, e.g., PostgreSQL]) for a strict block-section secondary school system with Tech-Voc (Technical-Vocational) support.

### Business Rules & Context:
1. The school operates on a strict "block section" model. There are NO irregular students. 
2. Students are enrolled in exactly ONE section per term.
3. A section is assigned to a specific Grade Level and Tech-Voc Program.
4. Schedules are fixed per section. The schedule dictates what Subject, Teacher, Room, and Time Slot a section is assigned to.
5. Strict database constraints must be implemented to prevent data anomalies (e.g., duplicate enrollments, scheduling conflicts).

### Please create the following tables with appropriate Primary Keys (PK), Foreign Keys (FK), and data types:

1. Master Data Tables:
- `Term`: term_id, name, status (e.g., active/inactive)
- `Program`: program_id, track_name, specialization (e.g., "TVL - ICT")
- `Subject`: subject_id, name, subject_type (e.g., core, specialized)
- `Teacher`: teacher_id, first_name, last_name, specialty
- `Room`: room_id, name, room_type (e.g., lecture, computer lab)
- `Time_Slot`: slot_id, day_of_week, start_time, end_time

2. Core Tables:
- `Section`: section_id, name, grade_level, program_id (FK), term_id (FK)
- `Student`: student_id, lrn (Learner Reference Number), first_name, last_name
- `Enrollment`: enrollment_id, student_id (FK), section_id (FK)

3. Schedule Table:
- `Section_Schedule`: schedule_id, section_id (FK), subject_id (FK), teacher_id (FK), room_id (FK), slot_id (FK)

### Required Constraints & Triggers to generate:
- Add a UNIQUE constraint on the `Enrollment` table to ensure a student can only be enrolled in one section per term (you will need to join or check against the Section table's term_id).
- Add a UNIQUE constraint on `Section_Schedule` for (teacher_id, slot_id) to prevent a teacher from being double-booked.
- Add a UNIQUE constraint on `Section_Schedule` for (room_id, slot_id) to prevent a room from being double-booked.
- Add a UNIQUE constraint on `Section_Schedule` for (section_id, slot_id) to prevent a section from being scheduled for two different subjects at the same time.

Please output the raw SQL script to create this schema, complete with `CREATE TABLE` statements, foreign key constraints, and the unique constraints mentioned above. Include standard indexing for foreign keys to optimize query performance.