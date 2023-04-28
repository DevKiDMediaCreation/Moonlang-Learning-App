@echo off
cls
git init
git add README.md
git add *
git commit -m "New update from automation commands"
git branch -M main
git remote add origin git@github.com:DevKiDMediaCreation/Molingo.git
git push -u origin main
cls
echo Success to create
