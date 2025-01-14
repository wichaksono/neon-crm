<?php

namespace App\Models\Common\Constants;

class TasksConstant
{
    /**
     * Task types.
     *
     * @var array<string, string>
     */
    public const TASK_TYPES = [
        'task'          => 'Task',
        'task_lead'     => 'Task Lead',
        'task_customer' => 'Task Customer',
        'project'       => 'Project',
        'agenda'        => 'Agenda',
        'todos'         => 'To Do',
    ];

    /**
     * Type: Task
     *
     * @var string
     */
    public const TASK_TYPE_TASK = 'task';

    /**
     * Type: Project
     *
     * @var string
     */
    public const TASK_TYPE_PROJECT = 'project';

    /**
     * Type: Agenda
     *
     * @var string
     */
    public const TASK_TYPE_AGENDA = 'agenda';

    /**
     * Type: Agenda Lead
     *
     * @var string
     */
    public const TASK_TYPE_TASK_LEAD = 'task_lead';

    /**
     * Type: Agenda Customer
     *
     * @var string
     */
    public const TASK_TYPE_TASK_CUSTOMER = 'task_customer';

    /**
     * Type: To Do
     *
     * @var string
     */
    public const TASK_TYPE_TODOS = 'todos';

    /**
     * Task assigned types.
     *
     * @var array<string, string>
     */
    public const TASK_ASSIGNED_TYPES = [
        'employee'   => 'Employee',
        'group'      => 'Group',
        'department' => 'Department',
        'job'        => 'Job',
        'user'       => 'User',
    ];

    /**
     * Assigned type: User
     *
     * @var string
     */
    public const TASK_ASSIGNED_TYPE_USER = 'user';

    /**
     * Assigned type: Team
     *
     * @var string
     */
    public const TASK_ASSIGNED_TYPE_TEAM = 'team';

    /**
     * Assigned type: Department
     *
     * @var string
     */
    public const TASK_ASSIGNED_TYPE_DEPARTMENT = 'department';

    /**
     * Assigned type: Job
     *
     * @var string
     */
    public const TASK_ASSIGNED_TYPE_JOB = 'job';

    /**
     * Task statuses.
     *
     * @var array<string, string>
     */
    public const TASK_STATUSES = [
        'todo'        => 'To Do',
        'in-progress' => 'In Progress',
        'in-review'   => 'In Review',
        'done'        => 'Done',
    ];

    /**
     * Status: To Do
     *
     * @var string
     */
    public const TASK_STATUS_TODO = 'todo';

    /**
     * Status: In Progress
     *
     * @var string
     */
    public const TASK_STATUS_IN_PROGRESS = 'in-progress';

    /**
     * Status: In Review
     *
     * @var string
     */
    public const TASK_STATUS_IN_REVIEW = 'in-review';

    /**
     * Status: Done
     *
     * @var string
     */
    public const TASK_STATUS_DONE = 'done';

}
