**Role & Context:**
Act as a Senior Full-Stack Developer and Architect specializing in the TALL stack (Tailwind CSS 4, Alpine.js, Laravel 13, Livewire 3). We are building ASPIRE, a SaaS enrollment system for secondary/tech-voc schools in the Philippines.

**The Task:**
Implement the complete "Single Gateway" public enrollment flow. We are intentionally avoiding standard user registration or OAuth for the public-facing application to eliminate friction and prevent junk data in the primary users table. 

The single entry point strictly uses the student's Learner Reference Number (LRN) and Birthdate.

**Database Requirements:**
Create a `PreEnrollment` model and migration. Key columns: `lrn` (string, unique), `birthdate` (date), `current_step` (integer), `status` (enum: 'draft', 'pending_approval'), and `form_data` (jsonb) to hold all dynamic form inputs.

**Livewire Component Requirements (`EnrollmentWizard`):**
Create a full-page Livewire 3 component that handles both the gateway logic and the multi-step form.

1. **The Gateway State (Step 0):** The component mounts with two inputs: `lrn` and `birthdate`. Upon submission, execute the following logic:
   - *Scenario A (Brand New):* If the LRN is not found in `pre_enrollments` or the main `students` table, initialize a new draft record and advance the component to Step 1.
   - *Scenario B (Resume Draft):* If the LRN exists in `pre_enrollments` with a 'draft' status, verify the birthdate. If it matches, hydrate the Livewire component's state with the JSON data and advance the user directly to their saved `current_step`.
   - *Scenario C (Already Enrolled):* If the LRN exists in the main `students` table, reject the entry and return a redirect with a flash message: "You are already officially enrolled. Please log in to the Student Portal."

2. **The Multi-Step Form (Step 1+):** - Manage the form progress using a `$currentStep` property.
   - Implement an auto-save mechanism. Bind form inputs using `wire:model`, and when the user clicks "Next" to advance a step, fire a Livewire method that automatically updates the `form_data` and `current_step` in the database.

3. **Data Masking (Security):** - If the component hydrates with existing data (Scenario B: Resuming a draft), utilize a PHP method or a `#[Computed]` property to mask sensitive data in the Blade view (e.g., displaying `0917-***-**45` instead of the full number). This prevents unauthorized viewing by someone guessing a classmate's birthdate.

**Technical Constraints:**
- Rely heavily on Livewire 4 features for state management and form submission. Use Alpine.js only for minor client-side UI toggles (like modals or dropdowns) where a server roundtrip is unnecessary.
- Ensure all styling and script dependencies are configured to be downloaded and served locally via your asset pipeline. Do not use external CDNs for fonts, Tailwind, or scripts.
- Use strict type hinting and modern PHP 8.5 syntax.
- Provide the database migration, the Livewire component PHP class, and the corresponding Blade view.