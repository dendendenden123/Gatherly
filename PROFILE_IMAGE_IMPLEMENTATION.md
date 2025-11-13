# Profile Image Upload Functionality Implementation

## Summary
Added full profile image and document upload functionality to the member edit page with proper validation, preview, and database storage.

## Changes Made

### 1. Database (Already Existed)
- **Table**: `users`
- **Columns**: 
  - `profile_image` (string, nullable) - Default: Default profile image URL
  - `document_image` (string, nullable)
- **Migration**: `0001_01_01_000000_create_users_table.php`

### 2. Backend (Already Implemented)
- **Controller**: `UserController.php`
- **Method**: `update()` (lines 233-250)
- **Storage**: Files stored in `storage/app/public/profiles/`
- **Validation**: 
  - Profile Image: JPG, PNG (Max 2MB)
  - Document: JPG, PNG, PDF (Max 5MB)
- **Features**:
  - Automatic deletion of old files when uploading new ones
  - Stores relative path in database (e.g., `profiles/filename.jpg`)
  - Uses Laravel's Storage facade for file handling

### 3. Frontend Enhancements (NEW)

#### File: `resources/views/admin/members/edit.blade.php`

**A. Profile Image Upload (Lines 178-194)**:
- Added unique IDs to all elements
- Image preview showing existing or newly uploaded images
- Conditional rendering based on existing profile image
- Shows existing profile image on page load if available
- Hides icon when image is displayed

**B. Document Upload (Lines 196-227)**:
- Preview for both images and PDF files
- For PDF files: Shows PDF icon with filename and "View PDF" link
- For images: Shows image thumbnail preview
- Displays existing documents on page load
- Separate handling for PDF vs image files

**C. JavaScript Functionality (Lines 218-410)**:

**Profile Image Features**:
- Image preview with circular crop
- Drag & drop support
- File validation (JPG/PNG only, max 2MB)
- Real-time error messages using SweetAlert2
- Visual feedback on interaction

**Document Upload Features**:
- Smart preview: Images show thumbnails, PDFs show icon with link
- Drag & drop support
- File validation (JPG/PNG/PDF, max 5MB)
- Real-time error messages using SweetAlert2
- PDF preview link with blob URL
- Handles existing documents (images or PDFs)

#### File: `resources/views/admin/members/show.blade.php` (Line 10-14)
- Updated to display user's actual profile image
- Falls back to default image if none uploaded
- Uses `asset('storage/' . $user->profile_image)` for proper URL generation

## Usage Instructions

### For Admin Users:

#### Profile Image Upload:
1. Navigate to Members → Edit Member
2. Scroll to "Document Upload" section
3. Click on "Profile Image" area OR drag and drop
4. Preview shows immediately (circular thumbnail)
5. File is validated (JPG/PNG, max 2MB)
6. Click "Update Account" to save

#### Document Upload:
1. Same page, "Document Image" area
2. Click or drag and drop file
3. Preview behavior:
   - **Images**: Shows thumbnail preview
   - **PDF**: Shows PDF icon with "Preview PDF" link
4. File is validated (JPG/PNG/PDF, max 5MB)
5. Click "Update Account" to save

### File Storage:
- Uploaded files: `storage/app/public/profiles/`
- Public access: `public/storage/profiles/` (via symlink)
- Database: Stores relative path (e.g., `profiles/abc123.jpg`)

### To Enable Storage Access:
Run this command to create symbolic link (if not already done):
```bash
php artisan storage:link
```

## Preview Features

### Profile Image:
- Shows existing image as circular thumbnail
- New uploads show instant preview
- Replaces icon with image preview

### Document Image:
- **For existing images**: Displays thumbnail
- **For existing PDFs**: Shows PDF icon + filename + "View PDF" link
- **For new image uploads**: Shows instant thumbnail preview
- **For new PDF uploads**: Shows PDF icon + filename + "Preview PDF" link (clickable)

## Error Handling

### Frontend Validation:

**Profile Image**:
- Invalid file type → SweetAlert error: "Please upload a JPG or PNG image"
- File too large → SweetAlert error: "Profile image must be less than 2MB"

**Document**:
- Invalid file type → SweetAlert error: "Please upload a JPG, PNG, or PDF file"
- File too large → SweetAlert error: "Document must be less than 5MB"

All errors clear the file input automatically.

### Backend Validation:
- Validation rules in `UserController@update` (line 218)
- Returns back with errors if validation fails
- Logs errors for debugging

## Security Features
1. File type validation (both frontend and backend)
2. File size limits enforced
3. Old files automatically deleted to prevent storage bloat
4. Files stored outside public directory (via storage)
5. Proper MIME type checking
6. Accept attribute restricts file picker to valid types

## Technical Details

### Preview Implementation:
- **Image Files**: Uses FileReader API to create data URLs
- **PDF Files**: Uses URL.createObjectURL() for preview links
- **Conditional Display**: Blade conditionals check file extensions
- **Smart Hiding/Showing**: JavaScript toggles visibility of icon, image, and PDF containers

### File Detection:
- Backend: Uses `str_ends_with()` to check `.pdf` extension
- Frontend: Checks `file.type === 'application/pdf'`

## Notes
- Both fields are optional (can skip uploads)
- Default image URL used if no profile image uploaded
- Maintains existing files if no new files uploaded
- Profile and document uploads are independent
- PDF preview opens in new tab for full viewing

