# CONTRIBUTING

### **Adding Labels to Commit Messages**

To maintain a clean and organized commit history, we use **labels** in commit messages. Labels help categorize changes and make it easier to understand the purpose of each commit at a glance.

---

### **Why Use Labels?**
- **Clarity**: Labels provide context about the type of change being made.
- **Searchability**: They make it easier to filter and search through commit history.
- **Consistency**: They ensure all contributors follow the same conventions.

---

### **How to Add Labels**
1. **Format**:
    - Start your commit message with a label in square brackets, followed by a short description of the change.
    - Example: `[feat] Add user authentication`.

2. **Scope (Optional)**:
    - If the change is specific to a part of the codebase, include a scope after the label.
    - Example: `[fix][auth] Resolve login issue`.

3. **Description**:
    - Write a clear and concise description of the change.
    - Use the imperative mood (e.g., "Add" instead of "Added" or "Adds").

4. **Body (Optional)**:
    - Provide additional context or details about the change in the body of the commit message.

5. **Footer (Optional)**:
    - Reference related issues or pull requests (e.g., `Closes #123`).

---

### **List of Labels**
Here’s a list of standard labels to use in commit messages:

| Label       | Description                                                                 |
|-------------|-----------------------------------------------------------------------------|
| `[feat]`    | A new feature or functionality.                                             |
| `[fix]`     | A bug fix or correction.                                                    |
| `[docs]`    | Documentation changes (e.g., README, comments, or API docs).                |
| `[style]`   | Code style changes (e.g., formatting, linting).                             |
| `[refactor]`| Code refactoring (no new features or bug fixes).                            |
| `[test]`    | Adding or modifying tests.                                                  |
| `[chore]`   | Maintenance tasks (e.g., updating dependencies, cleaning up code).          |
| `[ci]`      | Changes to CI/CD configuration or scripts.                                  |
| `[perf]`    | Performance improvements.                                                   |
| `[build]`   | Changes to the build system or external dependencies.                       |
| `[revert]`  | Reverting a previous commit.                                                |
| `[merge]`   | Merging branches or resolving merge conflicts.                              |
| `[wip]`     | Work in progress (for incomplete or draft changes).                         |

---

### **Examples**
1. **Simple Commit**:
   ```
   [feat] Add user authentication
   ```

2. **Commit with Scope**:
   ```
   [fix][auth] Resolve login issue
   ```

3. **Commit with Body and Footer**:
   ```
   [docs] Update README with installation instructions

   Add detailed steps for setting up the project locally.
   Include prerequisites and common issues.

   Closes #45
   ```

---

### **Best Practices**
1. **Be Consistent**:
    - Use the same labels and formatting across all commits.
2. **Keep It Short**:
    - Write concise commit messages (50–72 characters for the subject line).
3. **Use Imperative Mood**:
    - Write commit messages as if you’re giving a command (e.g., "Add" instead of "Added").
4. **Reference Issues**:
    - Use the footer to link commits to related issues or pull requests.

---

### **How to Contribute**
1. Fork the repository and create a new branch for your changes.
2. Make your changes and commit them using the label format.
3. Push your changes to your forked repository.
4. Open a pull request with a clear description of your changes.

---

By following these guidelines, you’ll help maintain a clean and organized commit history. Thank you for contributing! 😊