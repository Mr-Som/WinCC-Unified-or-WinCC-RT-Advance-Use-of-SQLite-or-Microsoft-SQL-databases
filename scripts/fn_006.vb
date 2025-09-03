Sub FN_006()

    On Error Resume Next ' Enable error handling

    Dim objConn, objRS, sqlQuery, checkQuery
    Dim dbPath, logFile, strError, fso, file, timeStamp
    Dim test_id, full_brk_applied, full_break_rel_iso, full_brk_rel_indic, full_brk_apply_indic

    ' Database and log paths from SmartTags
    dbPath = HmiRuntime.SmartTags("DB_PATH")
    logFile = HmiRuntime.SmartTags("LOG_PATH")

    ' Fetch ID
    test_id = HmiRuntime.SmartTags("NEW_RTR_TEST_ID")

    ' Convert values: 1 → Yes, else No
    If HmiRuntime.SmartTags("FULL_BRK_APPLIED") = 1 Then
        full_brk_applied = "Applied"
    Else
        full_brk_applied = "Not Applied"
    End If

    If HmiRuntime.SmartTags("FULL_BRK_REL_IN_ISO") = 1 Then
        full_break_rel_iso = "Yes"
    Else
        full_break_rel_iso = "No"
    End If

    If HmiRuntime.SmartTags("FULL_BRK_REL_INDIC") = 1 Then
        full_brk_rel_indic = "Green"
    Else
        full_brk_rel_indic = "No"
    End If

    If HmiRuntime.SmartTags("FULL_BRK_APPLY_INDIC") = 1 Then
        full_brk_apply_indic = "Red"
    Else
        full_brk_apply_indic = "No"
    End If

    ' Create ADODB connection
    Set objConn = CreateObject("ADODB.Connection")
    objConn.Open "Driver={SQLite3 ODBC Driver};Database=" & dbPath & ";"

    ' Check if ID exists
    checkQuery = "SELECT COUNT(*) AS cnt FROM tbl_lhb_04 WHERE id = " & test_id
    Set objRS = objConn.Execute(checkQuery)

    If objRS("cnt") > 0 Then
        ' If exists → UPDATE
        sqlQuery = "UPDATE tbl_lhb_04 SET " & _
                   "full_brk_applied='" & full_brk_applied & "'," & _
                   "full_brk_rel_in_iso='" & full_break_rel_iso & "'," & _
                   "full_brk_rel_indic='" & full_brk_rel_indic & "'," & _
                   "full_brk_apply_indic='" & full_brk_apply_indic & "' " & _
                   "WHERE id=" & test_id
    Else
        ' If not exists → INSERT
        sqlQuery = "INSERT INTO tbl_lhb_04 (" & _
                   "id, full_brk_applied, full_brk_rel_in_iso, full_brk_rel_indic, full_brk_apply_indic" & _
                   ") VALUES (" & _
                   test_id & ",'" & full_brk_applied & "','" & full_break_rel_iso & "','" & full_brk_rel_indic & "','" & full_brk_apply_indic & "')"
    End If

    ' Execute SQL query
    objConn.Execute sqlQuery

    ' Error handling
    If Err.Number <> 0 Then
        strError = "DB Error: " & Err.Description
        timeStamp = Now

        ' Log error to file
        Set fso = CreateObject("Scripting.FileSystemObject")
        Set file = fso.OpenTextFile(logFile, 8, True)
        file.WriteLine timeStamp & " - " & strError
        file.Close
        Err.Clear
    End If

    ' Close connection
    objConn.Close
    Set objConn = Nothing
    Set objRS = Nothing

End Sub