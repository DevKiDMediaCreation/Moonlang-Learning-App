@echo off
cls
git init
git add *
git commit -m "New update from automation commands. Ver: 1.0.0.4"
git branch -M main
git remote add origin git@github.com:DevKiDMediaCreation/Molingo.git
git push -u origin main
cls
echo Success to create
