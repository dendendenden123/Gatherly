Set WshShell = CreateObject("WScript.Shell") 
WshShell.Run chr(34) & "C:\xampp\htdocs\Gatherly\run_schedule.bat" & chr(34), 0
Set WshShell = Nothing
