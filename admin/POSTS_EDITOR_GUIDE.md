# Whoba Ogo Foundation - Posts Editor Guide

## New Features

### 1. Custom Published Date
You can now set the publication date to any date in the past or future. This is useful for:
- **Past Events**: Assign the correct date to events that already happened
- **Scheduled Posts**: Set a future date when you want the post to appear

**How to use:**
1. Go to the "Published Date" field in the post editor
2. Click the date/time picker
3. Select the date and time when the post was/will be published
4. The post status will determine when it becomes visible:
   - **Published**: Post is live (uses your selected date)
   - **Draft**: Post is hidden (editing only)
   - **Scheduled**: Post will auto-publish at the scheduled time
   - **Archived**: Post is hidden from listings

---

### 2. Inline Images with Sizing

You can now embed images directly in your post content with custom sizing. Images flow naturally with text.

#### Image Format:
```
![Alt text|width x height](image-url)
```

#### Examples:

**Basic image (auto height):**
```
![Featured Event|600](https://example.com/event.jpg)
```

**Image with specific dimensions:**
```
![Health Program|800x400](https://example.com/health.jpg)
```

**On the left side of text:**
```
![Small icon|300x300](/assets/images/icon.jpg)

This text will flow next to the image on larger screens...
```

#### How to Insert Images:

**Method 1: Using the Image Button**
1. Click the **🖼 Image** button in the editor toolbar
2. Select an image from your computer
3. A dialog will ask for the width (required) and height (optional)
4. The markdown syntax will be inserted automatically
5. **Note:** In production, the image will be uploaded to your server and the path updated

**Method 2: Manual Markdown**
Simply type the image markdown directly:
```
![Event Photo|600x400](/assets/images/uploads/event-2024.jpg)

Here's what happened at the event...
```

#### Image Sizing Guidelines:

| Use Case | Width | Height |
|----------|-------|--------|
| Full-width featured image | 800-1000px | 400-600px |
| Content companion image | 400-600px | auto or 400-600px |
| Small icon/thumbnail | 200-300px | 200-300px |
| Hero/banner image | 1200px | 600-800px |

---

### 3. Complete Markdown Support

The editor supports standard Markdown:

#### Text Formatting
- **Bold**: `**text**` → **text**
- *Italic*: `*text*` → *text*
- `Code`: `` `code` `` → `code`

#### Headings
```
# Heading 1
## Heading 2
### Heading 3
```

#### Lists
```
- Item 1
- Item 2
- Item 3
```

#### Links
```
[Link text](https://example.com)
```

---

## Complete Post Example

Here's a complete post with all features:

```
# Whoba Ogo Foundation Launches New Health Initiative

## Overview

![Health Program Launch|800x450](/assets/images/health-launch.jpg)

We are thrilled to announce the launch of our new health support program 
in three rural communities across Nigeria.

## Key Objectives

- Provide affordable healthcare access
- Train community health workers
- Establish local medical centers
- Partner with existing hospitals

## Community Impact

![Health Workers Training|600x400](/assets/images/training.jpg)

Over 50 community health workers have already been trained. 
They are now serving 5,000+ residents in their respective communities.

## Get Involved

You can support this initiative by:

1. Making a donation
2. Volunteering as a medical professional
3. Spreading awareness in your network

Learn more at our website: [whobaogofoundation.org](https://whobaogofoundation.org)
```

---

## Best Practices

### Date Selection Tips
✅ **Do:**
- Use actual event dates for past events
- Schedule important announcements in advance
- Set accurate published_at for search/archive features

❌ **Don't:**
- Leave dates at the creation time if post is about a past event
- Schedule too far in advance without reviewing

### Image Best Practices
✅ **Do:**
- Use descriptive alt text (e.g., "Health workers at clinic")
- Optimize image file sizes before uploading
- Use consistent image dimensions across similar posts
- Test images on mobile devices

❌ **Don't:**
- Use overly large images (>2MB per image)
- Use unclear alt text (e.g., "IMG12345")
- Mix portrait and landscape without planning layout
- Forget to set appropriate widths for mobile

### Content Best Practices
✅ **Do:**
- Keep paragraphs short (3-4 sentences max)
- Use heading hierarchy (H1 → H2 → H3)
- Include images every 2-3 paragraphs
- Write for mobile-first viewing

❌ **Don't:**
- Use only one heading style
- Create walls of text without breaks
- Make assumptions about image sizes
- Skip the excerpt/summary field

---

## SEO Optimization

When creating a post:

1. **Title** (60-70 characters):
   ```
   ✅ "Whoba Ogo Launches Free Health Program for Rural Communities"
   ❌ "New program" (too vague)
   ```

2. **Meta Description** (150-160 characters):
   ```
   ✅ "Learn how our new health support initiative is bringing 
      affordable healthcare to 5,000+ residents in rural Nigeria."
   ❌ "About the program" (too short, not descriptive)
   ```

3. **Keywords** (3-5 relevant terms):
   ```
   Health support Nigeria, rural healthcare, community health workers
   ```

4. **Excerpt** (summary for listings):
   ```
   Clear, engaging summary that appears on the blog list page
   ```

---

## Image Upload Destination

**Future Enhancement:**
Currently, images are referenced by path. In production:
- Implement `/admin/upload-image.php` to handle server uploads
- Store images in `/assets/images/uploads/`
- Return the actual server path in the JSON response
- The editor will automatically insert the correct URL

**For now:**
1. Upload images manually to `/assets/images/uploads/`
2. Use the full path in the markdown: `/assets/images/uploads/filename.jpg`

---

## Troubleshooting

### Image Not Showing
- Check the image path is correct
- Verify the file exists on your server
- Ensure file permissions allow public reading
- Try with absolute URL if relative path fails

### Post Not Publishing
- Check the status is set to "Published"
- Verify the published_at date/time is correct
- Ensure no validation errors in the form

### Images Not Sizing Correctly
- Use consistent aspect ratios for related images
- Mobile view automatically adjusts image sizes
- Use percentages or max-width in CSS for responsive design

---

## Support

For questions or issues:
1. Check the "Form Hints" in the editor (the grey text under fields)
2. Review this guide
3. Contact the development team

Happy writing! 📝