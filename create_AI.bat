@echo off
cls
git init
git add *
git commit -m "AI: 0.1"
git branch -M main
git remote add origin git@github.com:DevKiDMediaCreation/Molingo.git
git push -u origin main
cls
echo Success to create
