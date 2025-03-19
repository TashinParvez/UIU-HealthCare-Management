# Git Workflow Guide

This guide will help you follow the correct Git workflow while working on this project. Please follow these steps carefully to avoid mistakes.

## 🚀 Pushing Your Code (Make Sure You Are on Your Own Branch)

When you want to add your new code to Git, follow these steps:

1. **Check the status of your changes:**
   ```sh
   git status
   ```
2. **Stage all changes:**
   ```sh
   git add -A
   ```
3. **Commit your changes with a meaningful message:**
   ```sh
   git commit -m "feat: adding home page CSS"
   ```
4. **Push your changes to your branch:**
   ```sh
   git push
   ```

## 🔄 Syncing with the Main Branch Before Working

Before starting your work, make sure your branch has the latest code from the `main` branch.

#### 1️⃣ Fetch the Latest Code from `main`

First, visit the main branch repository:  
🔗 [Main Branch](https://github.com/TashinParvez/UIU-HealthCare-Management)

Then, in your **local device**, run:

```sh
git pull origin main
```

> **Note:** Make sure you are on your own branch before pulling changes.

## 🔀 Switching Branches

To switch to your branch, use:

```sh
git checkout [your-branch-name]
```

Replace `[your-branch-name]` with your actual branch name.
