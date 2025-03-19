## Best Practices for Industry-Standard Commenting

### 1. **Explain the "Why," Not Just the "What"**

Code itself often shows what’s happening (e.g., `x = 5`). Comments should explain the `intent`, business `logic`, or `reasoning` behind it.

### 2. **Use Comments Sparingly**

Don’t comment obvious code—it adds noise. Reserve comments for complex logic, edge cases, or non-intuitive decisions.

### 3. **Follow Language-Specific Conventions**

Each language has its own commenting style (e.g., `//` in JS/C++, `/* */` for multi-line, `<!-- -->` in HTML). Stick to these for consistency.

### 4. Document Public APIs

For functions, classes, or modules others will use, include purpose, parameters, return values, and exceptions. Use tools like JSDoc (JS) or Doxygen (C/C++).

### 5. **Keep Comments Up-to-Date**

Outdated comments are worse than none. Update them when the code changes.

### 6. **Use TODOs and FIXMEs Judiciously**

Mark incomplete work or known issues, but don’t let them pile up—address them in your workflow.

### 7. **Group Comments for Context**

At the top of files or sections, summarize the purpose or architecture to give readers a high-level view.

### 8. **Avoid Humor or Irrelevant Notes**

Comments like "LOL this works" don’t age well in professional codebases.

---

### Examples in HTML, CSS, JavaScript, and C/C++

#### 1. HTML

```html
<!-- Main navigation bar for the site -->
<nav class="navbar">
  <!-- Logo links back to homepage for consistent UX -->
  <a href="/" class="logo">MyApp</a>
  <ul>
    <!-- Navigation items dynamically populated via JS -->
    <li><a href="/about">About</a></li>
    <li><a href="/contact">Contact</a></li>
  </ul>
</nav>

<!-- 
  Footer section with legal info and social links.
  Separated from main content for accessibility and SEO.
-->
<footer>
  <p>&copy; 2025 MyApp. All rights reserved.</p>
</footer>
```

- **Why It’s Good**: Comments describe the purpose of sections and UX decisions, not just the tags. They’re concise and placed where they add value.

---

#### 2. CSS

```css
/* Consistent spacing across all pages */
:root {
  --spacing-unit: 16px;
}

/* 
  Hero section styling.
  Uses larger padding on mobile to improve tap targets (WCAG compliance).
*/
.hero {
  padding: var(--spacing-unit);
  background: url("/hero-bg.jpg") no-repeat center/cover;
}

@media (max-width: 768px) {
  .hero {
    padding: calc(var(--spacing-unit) * 2);
  }
}

/* Reset button styles to avoid browser inconsistencies */
button {
  border: none;
  background: none;
}
```

- **Why It’s Good**: Comments explain design decisions (e.g., accessibility) and global conventions (e.g., CSS variables). No redundant comments like “sets padding” since the code is clear.

---

#### 3. JavaScript

```javascript
// Fetch user data from API and update UI
async function loadUserProfile(userId) {
  try {
    // Using fetch with timeout to avoid hanging on slow networks
    const response = await fetchWithTimeout(`/api/users/${userId}`, 5000);
    const user = await response.json();
    updateUI(user);
  } catch (error) {
    // Log error for debugging but show user-friendly message
    console.error("Profile load failed:", error);
    showError("Unable to load profile. Please try again.");
  }
}

/**
 * Fetch with a timeout to prevent indefinite waits.
 * @param {string} url - API endpoint
 * @param {number} timeout - Timeout in milliseconds
 * @returns {Promise<Response>} - Fetch response
 */
async function fetchWithTimeout(url, timeout) {
  const controller = new AbortController();
  const id = setTimeout(() => controller.abort(), timeout);
  const response = await fetch(url, { signal: controller.signal });
  clearTimeout(id);
  return response;
}
```

- **Why It’s Good**: High-level intent is at the top, edge cases (timeout) are explained inline, and JSDoc documents the reusable function for API consumers. No clutter from obvious comments.

---

#### 4. C/C++

```cpp
#include <iostream>

// Constants for retry logic
const int MAX_RETRIES = 5;  // Based on server SLA for availability

/*
 * Attempts to connect to the server with exponential backoff.
 * Returns true if successful, false if all retries fail.
 */
bool connectToServer(int attempt = 0) {
  if (attempt >= MAX_RETRIES) {
    return false;  // Exhausted retries
  }

  // Simulate connection (replace with actual socket code)
  bool success = (rand() % 2 == 0);  // 50% success rate for demo
  if (!success) {
    int delay = 1 << attempt;  // Exponential backoff: 1s, 2s, 4s...
    sleep(delay);
    return connectToServer(attempt + 1);
  }
  return true;
}

int main() {
  // Entry point: Test server connection
  if (connectToServer()) {
    std::cout << "Connected successfully\n";
  } else {
    std::cout << "Connection failed after retries\n";
  }
  return 0;
}
```

- **Why It’s Good**: File-level constants are explained, function purpose and logic (backoff) are documented, and inline comments clarify non-obvious math. The main function gets a brief context comment.
